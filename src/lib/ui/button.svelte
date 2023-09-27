<script>
	import { SUBMIT } from './button';

	/**
	 * @type {null|symbol}
	 */
	export let type = null;
	export let inverted = false;
	export let href = '';
	const classes = [
		'inline-block',
		'transition',
		'cursor-pointer',
		'no-underline',
		'rounded-3xl',
		'py-2',
		'px-3',
		'border-0'
	];

	if (inverted) {
		classes.push('text-green', 'bg-white', 'hover:bg-near-white', 'hover:text-dark-green');
	} else {
		classes.push('text-white', 'bg-green', 'hover:bg-dark-green');
	}
</script>

{#if type === SUBMIT}
	<button type="submit" class={classes.join(' ')}><slot /></button>
{:else}
	<a {href} class={classes.join(' ')}><slot /></a>
{/if}
