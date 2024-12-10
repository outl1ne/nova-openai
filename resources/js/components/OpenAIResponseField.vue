<template>
    <panel-item :field="field">
        <template #value>
            <div class="openai-response-field" v-html="field.displayValue" />
        </template>
    </panel-item>
</template>

<script>
export default {
    props: ["resourceName", "field"],
};
</script>

<style scoped>
.openai-response-field {
    padding: 10px;
    border-radius: 8px;
    border-left: 1px solid #eee;
    max-height: 600px;
    overflow-y: auto;
}

.openai-response-field :deep(pre) {
    white-space: pre-wrap;
    word-wrap: break-word;
    margin: 0;
    padding: 10px;
    border-radius: 8px;
}

.openai-response-field :deep(.message) {
    margin-bottom: 15px;
}

.openai-response-field :deep(.role) {
    font-weight: bold;
    margin-bottom: 5px;
}

.openai-response-field :deep(.content) {
    white-space: pre-wrap;
    word-wrap: break-word;
}

.openai-response-field :deep(hr) {
    margin: 15px 0;
    border: none;
    border-top: 1px solid #eee;
}
</style>
