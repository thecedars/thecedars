<script lang="ts">
	import { createEventDispatcher } from 'svelte';

	const dispatch = createEventDispatcher();

	function handleKeyPress(event: KeyboardEvent) {
		dispatch('click', event);
	}
</script>

<div
	class="rounded-2xl p-4 transition-colors hover:bg-green hover:text-white bg-washed-green flex items-center justify-center text-center cursor-pointer"
	on:click
	on:keypress={handleKeyPress}
	role="button"
	tabindex="0"
>
	<div><slot /></div>
</div>
