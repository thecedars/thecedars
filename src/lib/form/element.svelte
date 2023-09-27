<script>
	/**
	 * @type {string}
	 */
	export let element;

	/**
	 * @type {any}
	 */
	export let elementProps;

	/**
	 * @type {string[]}
	 */
	export let options = [];
</script>

{#if options.length}
	<svelte:element this={element} {...elementProps} on:input on:focus on:blur on:change>
		{#each options as option}
			<option value={option}>{option}</option>
		{/each}
	</svelte:element>
{:else}
	<svelte:element this={element} {...elementProps} on:input on:focus on:blur on:change />
{/if}
