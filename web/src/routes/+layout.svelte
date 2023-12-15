<script lang="ts">
	import Footer from '$lib/ui/footer.svelte';
	import Header from '$lib/ui/header.svelte';

	import './layout.css';
</script>

<div
	class="bg-washed-green min-h-screen flex items-stretch flex-col w-full overflow-x-hidden sans-serif near-black relative z-1"
>
	<Header />
	<div class="main leading-normal relative z-1 flex-auto flex items-center justify-center">
		<div class="w-full max-w-5xl px-4 mx-auto">
			<slot />
		</div>
	</div>
	<Footer />
</div>

<svelte:head>
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin" />
	<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
	<title>The Cedars &#8211; a piece of paradise</title>
	<meta
		name="description"
		content="The Cedars is between Pflumm Road and Lackman Drive in the city of Lenexa, KS."
	/>
</svelte:head>
