<script lang="ts">
	import { marked } from 'marked';
	import { createEventDispatcher, onMount } from 'svelte';

	const dispatch = createEventDispatcher();

	export let name: string;
	export let label = '';
	export let id = name;
	export let rows = 3;
	export let markdown = false;
	export let required = false;

	let textarea: HTMLTextAreaElement;

	let propValue = '';
	let targetValue = '';
	let className = 'contents';

	$: value = targetValue || propValue;
	$: markdownHtml = markdown && (marked.parse(value) as string);

	function onChange(event: Event & { currentTarget: EventTarget & HTMLTextAreaElement }) {
		dispatch('input', event);
		const target = event.currentTarget;
		targetValue = target.value ?? '';
	}

	onMount(() => {
		const resetValue = () => {
			targetValue = '';
		};

		if (textarea) textarea.form?.addEventListener('reset', resetValue);

		return () => {
			if (textarea) textarea.form?.removeEventListener('reset', resetValue);
		};
	});

	export { className as class, propValue as value };
</script>

<div class={className}>
	{#if label}
		<label for={id} class="block text-sm font-medium leading-6 text-gray-900">
			{label}
			{#if required}<span class="text-red-600">*</span>{/if}
		</label>
	{/if}
	<div class="mt-2">
		<textarea
			bind:this={textarea}
			{id}
			name={markdown ? name + '-raw' : name}
			{rows}
			{required}
			{value}
			on:input={onChange}
			class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
		/>

		{#if markdown}<textarea class="sr-only" {name} value={markdownHtml ? markdownHtml : ''} />{/if}
	</div>

	{#if markdown && markdownHtml}
		<div
			class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md mt-10"
		>
			<div class="p-6">
				<h5
					class="mb-2 block font-sans text-xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased"
				>
					Preview
				</h5>
				<div class="block font-sans text-base font-light leading-relaxed text-inherit antialiased">
					<div class="no-tailwind">
						{@html markdownHtml}
					</div>
				</div>
			</div>
		</div>
	{/if}
</div>
