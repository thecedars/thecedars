<script lang="ts">
	import { applyAction, enhance } from '$app/forms';
	import { SUBMIT } from '$lib/ui/button';
	import Button from '$lib/ui/button.svelte';
	import type { SubmitFunction } from '@sveltejs/kit';
	import Field from './field.svelte';
	import Recaptcha from './recaptcha.svelte';
	import { page } from '$app/stores';

	let token = '';
	let loading = false;
	let error = '';
	let success = '';
	export let inquiry = '';

	$: error = $page.form?.error || '';
	$: success = $page.form?.success || '';

	function onInquiryChange(event: Event) {
		if (
			event.currentTarget instanceof HTMLInputElement ||
			event.currentTarget instanceof HTMLSelectElement
		) {
			inquiry = event.currentTarget.value;
		}
	}

	const submit: SubmitFunction = async function () {
		loading = true;
		success = '';
		error = '';

		return ({ update, result }) => {
			return update()
				.then(() => applyAction(result))
				.finally(() => {
					loading = false;
				});
		};
	};
</script>

<Recaptcha
	on:load={(event) => {
		token = event.detail.token;
	}}
/>

<form action="/contact-us/" use:enhance={submit} method="POST" class="the-cedars-form">
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
		<Field name="message" type="textarea" label="Message" required />
	</slot>

	<div class="py-2 text-white flex justify-center w-full">
		<Button type={SUBMIT} disabled={loading}>Send Message</Button>
	</div>

	<div class="h-20 md:hidden sm:block" />

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
