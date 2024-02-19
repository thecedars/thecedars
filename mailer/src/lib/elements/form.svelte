<script lang="ts">
	import type { Resident, Residents } from '$lib/residents';
	import { toBase64 } from '$lib/utils';
	import { onMount } from 'svelte';
	import Cancel from './cancel.svelte';
	import Input from './input.svelte';
	import Radio from './radio.svelte';
	import Submit from './submit.svelte';
	import Textarea from './textarea.svelte';
	import Upload from './upload.svelte';

	interface DuesCheckedItem {
		StreetName: string;
		City: string;
		State: string;
		Zip: string;
		LastName: string;
		ListingName: string;
		Phone: string;
		Children: string;
		Email: string;
		Notes: string;
		Number: string;
		BillingAddress: string;
		BillingPhone: string;
		BillingEmail: string;
		Flag_Print: string;
		Flag_OptionalBilling: string;
		Flag_HideEmail: string;
		'Check Date': string;
		'Check No.': string;
		'Date Deposited': string;
	}

	const DUES_PAID_ID = '1UMSFmFLy3iTSCda7CtHgT8uxUK1BoOEo0iGRJp0k-TM';

	let showTextEmailField = true;
	let form: HTMLFormElement | undefined;
	let goodMessage = '';
	let badMessage = '';
	let loading = false;
	let residents: Residents = [];
	let notPaid: DuesCheckedItem[] = [];

	function handleToChange(event: Event) {
		const target = event && 'currentTarget' in event ? event.currentTarget : null;
		const value = target && 'value' in target ? target.value : '';

		showTextEmailField = value === 'Test';
	}

	async function getValues() {
		const formdata = new FormData(form);
		const dataFromEntries = Object.fromEntries(formdata);
		const data: Record<string, string | string[]> = {};
		for (const entry in dataFromEntries) {
			const value = dataFromEntries[entry];
			if (value instanceof File) {
				data[entry] = await toBase64(value);
			} else {
				data[entry] = value.toString();
			}
		}

		if (data.whoto === 'Everyone') {
			data.to = residents.map((resident) => {
				if (resident.Email.includes(',')) {
					const a = resident.Email.split(',');
					return a[0].trim();
				}

				return resident.Email.trim();
			});
		} else if (data.whoto === 'Not Paid') {
			const notPaidAddresses = notPaid.map((n) => n.Number + n.StreetName);

			data.to = residents
				.filter((resident) => {
					const check = resident.StreetNumber + resident.StreetName;
					return notPaidAddresses.includes(check);
				})
				.map((resident) => {
					if (resident.Email.includes(',')) {
						const a = resident.Email.split(',');
						return a[0].trim();
					}

					return resident.Email.trim();
				});
		}

		return data;
	}

	async function send() {
		loading = true;
		goodMessage = '';
		badMessage = '';
		const data = await getValues();

		try {
			const response = await fetch('/api/mail', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(data)
			});

			const result = await response.json();

			if (result?.success) {
				goodMessage = 'Success!';
				form?.reset();
			} else {
				badMessage = 'Ooops';
			}
		} catch (e) {
			if (e instanceof Error) {
				console.error(e);
				badMessage = e.message;
			}
		} finally {
			loading = false;
		}
	}

	async function getResidents(): Promise<Resident[] | null> {
		try {
			const results = await fetch('/api/sheet', {
				headers: { 'Content-Type': 'application/json' }
			}).then((r) => r.json());

			return results.filter((row: Resident) => row.Email);
		} catch (e) {
			console.error(e);
		}

		return null;
	}

	async function getNotPaid(): Promise<DuesCheckedItem[] | null> {
		try {
			const results = await fetch('/api/sheet?sheetId=' + DUES_PAID_ID, {
				headers: { 'Content-Type': 'application/json' }
			}).then((r) => r.json());

			return results.filter((row: DuesCheckedItem) => {
				return !row['Check Date'];
			});
		} catch (e) {
			console.error(e);
		}

		return null;
	}

	function resetForm() {
		goodMessage = '';
		badMessage = '';
		form?.reset();
	}

	function saveToLocalStorage(field: string, value: string | undefined) {
		if (value) {
			window.localStorage.setItem('form_' + field, value);
		}
	}

	onMount(() => {
		getResidents().then((r) => {
			if (r) residents = r;
		});

		getNotPaid().then((r) => {
			if (r) notPaid = r;
		});
	});
</script>

{#if goodMessage}
	<div
		class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3 mb-4"
		role="alert"
	>
		<svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
			<path
				d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"
			/>
		</svg>
		<p>{goodMessage}</p>
	</div>
{/if}

{#if badMessage}
	<div role="alert" class="mb-4">
		<div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">Danger</div>
		<div class="border border-t-0 border-red-400 rounded-b bg-red-100 px-4 py-3 text-red-700">
			<p>{badMessage}</p>
		</div>
	</div>
{/if}

<form bind:this={form} on:submit|preventDefault={send}>
	<div class="space-y-12">
		<div class="border-b border-gray-900/10 pb-12">
			<h2 class="text-base font-semibold leading-7 text-gray-900">Email Tool</h2>
			<p class="mt-1 text-sm leading-6 text-gray-600">
				Email tool for emailing The Cedars HOA residents.
			</p>

			<div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
				<Input
					on:change={(e) => saveToLocalStorage('subject', e?.currentTarget?.value)}
					required
					name="subject"
					label="Subject"
					class="sm:col-span-4"
				/>

				<div class="sm:col-span-4">
					<Radio
						name="whoto"
						defaultValue="Test"
						options={['Everyone', 'Not Paid', 'Test']}
						label="To"
						on:change={handleToChange}
					/>
				</div>

				{#if showTextEmailField}
					<Input
						on:change={(e) => saveToLocalStorage('to', e?.currentTarget?.value)}
						required
						name="to"
						type="email"
						label="Test email"
						class="sm:col-span-4"
					/>
				{/if}

				<Textarea required rows={10} name="html" label="Message" class="col-span-full" markdown />

				<Upload label="Attachments" name="attachment" class="col-span-full" />
			</div>
		</div>
	</div>

	<div class="mt-6 flex items-center justify-end gap-x-6">
		{#if residents.length}
			<span
				title="Residents with email address"
				class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20"
			>
				{residents.length}
			</span>
		{/if}

		<Cancel on:click={resetForm}>Cancel</Cancel>
		{#if loading}
			<div
				class="animate-spin inline-block w-5 h-5 border-[3px] border-current border-t-transparent text-gray-400 rounded-full"
				role="status"
				aria-label="loading"
			>
				<span class="sr-only">Loading...</span>
			</div>
		{/if}
		<Submit disabled={loading}>Send</Submit>
	</div>
</form>
