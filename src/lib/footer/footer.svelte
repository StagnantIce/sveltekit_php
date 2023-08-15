<script lang="ts">
    export let copyrights: string;
    import s from './footer.module.css';
</script>


<div class={s.footer}>
    {@html copyrights }
</div>
