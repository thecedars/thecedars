<script lang="ts">
	export let disabled = false;
</script>

<button
	{disabled}
	type="submit"
	on:click
	on:keypress
	class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
>
	<slot />
</button>
