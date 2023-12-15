<script lang="ts">
	import { getContext } from 'svelte';

	const parentName = getContext<string>('name');

	export let name: string;
	export let label = '';
	export let id = [parentName, name].join('-');
	export let value = '';
	export let selected = false;
	let className = 'contents';

	export { className as class };
</script>

<div class={className}>
	<div class="flex items-center gap-x-3">
		<input
			{id}
			{value}
			name={parentName}
			on:change
			type="radio"
			checked={selected}
			class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600"
		/>
		{#if label}
			<label for={id} class="block text-sm font-medium leading-6 text-gray-900">
				{label}
			</label>
		{/if}
	</div>
</div>
