<script lang="ts">
	import Title from '$lib/ui/title.svelte';
	import Card from './card.svelte';
	import { meetings } from './config';

	const YEAR = new Date().getFullYear();
	let anchor: HTMLElement & { href: string };

	function openmap(address: string, full?: boolean) {
		if (!full) {
			address += ', Lenexa, KS 66215';
		}

		const url = new URL('https://maps.google.com');
		url.searchParams.set('q', address);

		anchor.href = url.toString();
		anchor.click();
	}
</script>

<Title>Meetings</Title>

<p id="noop">
	Board meetings are open to all members of The Cedars Homes Association. Meetings begin at 7:00pm
	and run for about an hour.&nbsp;
	<a href="/contact-us">Please RSVP to the Board President if you plan to attend</a>
	. You will find a map to the location of the meeting by clicking on the meeting location below.
</p>

<h2 class="font-bold pb-4">{YEAR} Meeting Schedule</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
	{#each meetings as meeting}
		<Card on:click={() => openmap(meeting.address, meeting.fulladdress)}>
			<h4>{meeting.date}</h4>
			<div>{meeting.name}</div>
		</Card>
	{/each}
</div>

<a href="#noop" target="_map" bind:this={anchor} class="sr-only">&nbsp;</a>
