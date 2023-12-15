<script lang="ts">
	export let element: string;
	export let elementProps: any;
	export let options: string[] = [];
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
