<script>
	import Form from '$lib/form/form.svelte';
	import Title from '$lib/ui/title.svelte';

	const YEAR = new Date().getFullYear();
</script>

<Title>Title Inquiry</Title>

<Form inquiry="Title Company" />
