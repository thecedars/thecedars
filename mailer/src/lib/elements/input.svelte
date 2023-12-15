<script lang="ts">
	import { onMount } from 'svelte';

	export let name: string;
	export let label = '';
	export let type = 'text';
	export let id = name;
	export let required = false;
	let value = '';
	let className = 'contents';

	onMount(() => {
		const storage = window.localStorage.getItem('form_' + name);
		if (storage) {
			value = storage;
		}
	});

	export { className as class };
</script>

<div class={className}>
	{#if label}
		<label for={id} class="block text-sm font-medium leading-6 text-gray-900">
			{label}
			{#if required}<span class="text-red-600">*</span>{/if}
		</label>
	{/if}
	<div class="mt-2">
		<input
			{type}
			{name}
			{required}
			{id}
			{value}
			on:change
			class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
		/>
	</div>
</div>
