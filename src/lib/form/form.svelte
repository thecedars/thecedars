<script lang="ts">
	import { createEventDispatcher } from 'svelte';
	import { PUBLIC_ALT_FORM_URL } from '$env/static/public';

	import { SUBMIT } from '$lib/ui/button';
	import Button from '$lib/ui/button.svelte';
	import Field from './field.svelte';
	import Recaptcha from './recaptcha.svelte';

	let form: HTMLFormElement;
	let token = '';
	let loading = false;
	let error = '';
	let success = '';
	export let inquiry = '';
	const dispatch = createEventDispatcher();

	function onInquiryChange(event: Event) {
		if (
			event.currentTarget instanceof HTMLInputElement ||
			event.currentTarget instanceof HTMLSelectElement
		) {
			inquiry = event.currentTarget.value;
		}
	}

	async function submit() {
		loading = true;
		success = '';
		error = '';

		const formdata = new FormData(form);
		const data = Object.fromEntries(formdata);
		data.gToken = token;

		const invalid = [...form.elements].filter((element) => !element.validity.valid);

		if (invalid.length) {
			invalid.forEach((element) => element.reportValidity());
			loading = false;
			error = 'Please fill out missing data';
			return;
		}

		let response;

		try {
			response = await fetch(PUBLIC_ALT_FORM_URL + '/submission/index.php', {
				method: 'POST',
				body: JSON.stringify(data),
				headers: { 'content-type': 'application/json' }
			});

			if (response.ok) {
				response = await response.json();

				if (response?.data) {
					error = '';
					success = 'The form was sent successfully.';

					form.reset();
					dispatch('submit', { data });
				}
			}
		} catch (e) {
			if (e instanceof Error) {
				error = e.message;
			}

			success = '';
			dispatch('error', { error: e });
		} finally {
			loading = false;
		}
	}
</script>

<Recaptcha
	on:load={(event) => {
		token = event.detail.token;
	}}
/>

<form on:submit|preventDefault={submit} bind:this={form} class="the-cedars-form">
	<slot>
		<Field
			label="Inquiry"
			type="select"
			options={['', 'General', 'Title Company', 'Directory']}
			required
			name="inquiry"
			value={inquiry}
			on:input={onInquiryChange}
		/>

		{#if 'Title Company' === inquiry}
			<Field required name="address" label="Address of Property" />
			<Field required name="seller" label="Seller's Name" />
			<Field required name="buyer" label="Buyer's Name" />
		{/if}

		<Field name="email" type="email" label="Email" required />
		<Field name="phone" type="tel" label="Phone" />
		<Field name="message" type="textarea" label="Message" />
	</slot>

	<div class="py-2 text-white flex justify-center w-full">
		<Button type={SUBMIT}>Send Message</Button>
	</div>

	{#if loading}&hellip;{/if}

	{#if error}
		<div class="block my-2 bg-white-200 text-red-600 p-2 msg-error">{@html error}</div>
	{/if}

	{#if success}
		<div class="my-2 flex items-center p-2 text-green bg-white-200 msg-success">
			<span>{@html success}</span>
		</div>
	{/if}
</form>
