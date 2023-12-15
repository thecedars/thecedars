<script lang="ts">
	import { setContext } from 'svelte';

	import RadioInput from './radio-input.svelte';

	export let name: string;
	setContext('name', name);

	export let options: string[] = [];
	export let label = '';
	export let defaultValue = '';
	let className = 'contents';

	export { className as class };
</script>

<div class={className}>
	<fieldset>
		{#if label}
			<legend class="text-sm font-semibold leading-6 text-gray-900">{label}</legend>
		{/if}
		<slot name="help" />
		<div class="mt-6 space-y-6">
			{#each options as option}
				<RadioInput
					selected={option === defaultValue}
					value={option}
					name={option}
					label={option}
					on:change
				/>
			{/each}
		</div>
	</fieldset>
</div>
