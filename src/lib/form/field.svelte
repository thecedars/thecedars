<script>
	import { onMount } from 'svelte';

	import Element from './element.svelte';

	/**
	 * @type {string}
	 */
	export let name;

	/**
	 * @type {string[]}
	 */
	export let options = [];

	/**
	 * @type {string|undefined}
	 */
	export let value = undefined;

	export let type = 'text';
	export let label = '';
	export let required = false;
	export let error = '';
	let className = '';
	let element = 'input';
	const id = 'id-' + name;
	const inputClass = 'block w-full text-base border p-2 box-border bg-transparent border-gray-300';
	/**
	 * @type {{class:string, name: string, id:string, type?:string, required: boolean, value?:string}}
	 */
	let elementProps = { class: inputClass, name, id, required, value };

	if (type === 'textarea') {
		element = 'textarea';
	} else if (type === 'select') {
		element = 'select';
	} else {
		if (elementProps) elementProps.type = type;
	}

	onMount(()=>{
		if (value) {
			elementProps = {...elementProps, value };
		}
	});

	export { className as class };
</script>

<div class={className}>
	{#if label}
		<label class="text-base mb-1" for={id}>
			<span>
				{label}
				{#if required}<span class="text-red-600">*</span>{/if}
			</span>
			<Element {element} {options} {elementProps} on:input on:focus on:blur on:change />
		</label>
	{:else}
		<Element {element} {options} {elementProps} on:input on:focus on:blur on:change />
	{/if}

	{#if error}
		<span class="text-sm p-2 text-red-600 bg-gray-100 block">
			{error}
		</span>
	{/if}
</div>
