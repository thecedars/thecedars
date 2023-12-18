<script lang="ts">
	import './layout.css';

	const navItemClass = 'px-2 py-1 bg-gray-400 hover:bg-gray-500 rounded-3xl text-sm text-white';
</script>

<div class="flex flex-col h-screen w-screen overflow-y-scroll overflow-x-hidden">
	<header class="bg-gray-200 py-2 flex gap-8 items-center justify-center">
		<a href="/" class={navItemClass}>Email Tool</a>
		<a href="/csv" class={navItemClass}>Mailer CSV Output</a>
	</header>
	<div class="grow w-full p-4 mx-auto max-w-2xl">
		<slot />
	</div>
	<footer class="text-xs py-2 text-center text-gray-800">The Cedars</footer>
</div>
