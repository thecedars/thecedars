<script lang="ts">
	export let disabled = false;
	export let href = '';

	interface ButtonProps {
		href?: string;
		disabled?: boolean;
		class: string;
	}

	let props: ButtonProps = {
		class:
			'rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600'
	};

	$: {
		if (href) {
			props = { ...props, href };
		} else {
			props = { ...props, disabled };
		}
	}
</script>

{#if props.href}
	<!-- svelte-ignore a11y-missing-attribute -->
	<a {...props}><slot /></a>
{:else}
	<button on:click on:keypress {...props}>
		<slot />
	</button>
{/if}
