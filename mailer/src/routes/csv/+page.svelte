<script>
	import Submit from '$lib/elements/submit.svelte';
	</script>

<div class="flex gap-4 justify-between items-center">
	<Submit href="/csv/all">Download CSV for all</Submit>
	<Submit href="/csv/87">Download CSV for along 87th</Submit>
	<Submit href="/csv/-87">Download CSV not along 87th</Submit>
</div>

<svelte:head>
	<title>CSV Output</title>
</svelte:head>
