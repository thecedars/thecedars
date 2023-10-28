<script lang="ts">
	import { createEventDispatcher, onMount } from 'svelte';

	const dispatch = createEventDispatcher();

	let opened = false;
	const classes = [
		'transition-opacity',
		'duration-500',
		'py-4',
		'fixed',
		'top-0',
		'left-0',
		'w-screen',
		'h-screen',
		'z-max',
		'bg-opacity-80',
		'bg-black',
		'flex',
		'items-center',
		'justify-center'
	];

	onMount(() => {
		setTimeout(() => {
			opened = true;
		}, 2);
	});

	function close(event: MouseEvent | KeyboardEvent) {
		dispatch('close', event);
	}

	function preventsClicksFromPropagating() {}
</script>

<div
	on:click={close}
	on:keypress={close}
	role="button"
	tabindex="-1"
	class={classes.join(' ')}
	class:opacity-100={opened}
	class:opacity-0={!opened}
>
	<!-- svelte-ignore a11y-no-static-element-interactions -->
	<div
		class="max-w-2xl bg-white p-4 rounded-md w-full max-h-screen overflow-x-auto"
		on:click|stopPropagation={preventsClicksFromPropagating}
		on:keypress|stopPropagation={preventsClicksFromPropagating}
	>
		<slot />
	</div>
</div>
