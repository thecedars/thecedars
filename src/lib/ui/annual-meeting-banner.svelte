<script lang="ts">
	import Field from '$lib/form/field.svelte';
	import Form from '$lib/form/form.svelte';
	import Lightbox from './lightbox.svelte';

	let opened = false;
	const now = new Date();
	const YEAR = now.getFullYear();
	const NEXTYEAR = YEAR + 1;
	const MONTH = ('0' + (now.getMonth() + 1)).slice(-2);
	const DAY = ('0' + now.getDate()).slice(-2);

	const DATE = `${YEAR}-${MONTH}-${DAY}`;

	function openToggle() {
		opened = !opened;
	}
</script>

<div
	class="bg-red-500 text-white p-4 cursor-pointer"
	on:click={openToggle}
	on:keypress={openToggle}
	role="button"
	tabindex={-1}
>
	<div class="text-center text-lg">
		Notice: Click here to fill out your proxy form for the November Annual Meeting
	</div>
</div>

{#if opened}
	<Lightbox on:close={openToggle}>
		<h1 class="text-center text-3xl mb-2">{YEAR} Proxy Statement</h1>
		<h2 class="text-center text-lg mb-4">Fill Out the Form Below</h2>
		<Form>
			<input name="subject" type="hidden" value="{YEAR} Proxy Statement" />
			<div class="flex items-center -mx-2">
				<label for="authorizeOther" class="cursor-pointer mx-2 shrink-0">
					<input
						type="radio"
						id="authorizeOther"
						name="authorize"
						value="Authorize 'authorizeOtherName' to Cast my Ballot"
					/>
					I authorize
				</label>
				<Field name="authorizeOtherName" class="mx-2" />
				<div class="mx-2 shrink-0">residing at</div>
				<Field name="authorizeOtherAddress" class="mx-2" />
			</div>

			<div class="mb-4">
				in the Cedars, to cast my ballot for all votes requiring resident decision at the annual
				meeting.
			</div>

			<div class="mb-4">
				<label for="authorizeSecretary" class="cursor-pointer">
					<input
						type="radio"
						name="authorize"
						id="authorizeSecretary"
						value="Authorize Secretary to Cast my Ballot"
					/>
					I authorize the Secretary of the Board of Directors of the Cedars Homes Association to cast
					my ballot for all votes requiring resident decision at the annual meeting.
				</label>
			</div>

			<div class="mb-4">
				<div class="font-bold">NOMINATION FOR DIRECTOR</div>
				You may nominate yourself. If nomination is for resident, please obtain permission prior to submitting
				the nomination.
			</div>

			<div class="flex items-center -mx-2">
				<div class="shrink-0 mx-2">I nominate</div>
				<Field class="mx-2" name="nominee" />
				<div class="mx-2 shrink-0">residing at</div>
				<Field class="mx-2" name="nomineeAddress" />
			</div>

			<div class="mb-4">
				in the Cedars, to be director of the CHA for the period January 1, {NEXTYEAR} through December
				31, {NEXTYEAR}.
			</div>

			<Field class="mb-4" name="email" required label="Email" />
			<Field class="mb-4" name="address" required label="Your Street Address" />

			<div class="mb-4 flex items-center">
				<div class="mx-2 shrink-0">Type your full name:</div>
				<Field class="mx-2" required name="residentFullName" />
				<div class="mx-2 shrink-0">Date:</div>
				<Field class="mx-2" name="date" type="date" value={DATE} />
			</div>
		</Form>
	</Lightbox>
{/if}
