<script>
	import HeaderMenu from './header-menu.svelte';
</script>

<div role="menu" class="contents">
	<HeaderMenu href="/tree-replacement-program">Tree Replacement</HeaderMenu>
	<HeaderMenu href="/welcome-new-residents">New Residents</HeaderMenu>
	<HeaderMenu href="/info">
		Information

		<svelte:fragment slot="children">
			<HeaderMenu href="/contact-us">Contact Us</HeaderMenu>
			<HeaderMenu href="/info">Trash and Recycling</HeaderMenu>
			<HeaderMenu href="https://the-cedars.org/resources/budget-2023.pdf">Budget (2023)</HeaderMenu>
			<HeaderMenu href="/officers">Officers</HeaderMenu>
			<HeaderMenu href="/street-map">Street Map</HeaderMenu>
			<HeaderMenu href="/useful-links">City Links</HeaderMenu>
		</svelte:fragment>
	</HeaderMenu>
	<HeaderMenu href="/meetings">Meetings</HeaderMenu>
	<HeaderMenu href="/contact-us">General Contact</HeaderMenu>
</div>
