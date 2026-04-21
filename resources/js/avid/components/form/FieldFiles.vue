<script setup lang="ts">
import { Field, HasFile, HasPlaceholder, HasSize } from '@/avid/types/form';
import { usePrimeVue } from 'primevue/config';
import { FileUploadRemoveEvent, FileUploadSelectEvent } from 'primevue/fileupload';
import FormControl from './FormControl.vue';

interface Props extends Field, HasSize, HasPlaceholder, HasFile {
    fileLimit?: number;
}

withDefaults(defineProps<Props>(), {});

const model = defineModel<any[] | null | undefined>();
const $primevue = usePrimeVue();

const onFileSelect = (e: FileUploadSelectEvent) => {
    if (!e.files.length) {
        return;
    }

    if (!model.value) {
        model.value = [];
    }

    const files = model.value ? [...model.value] : [];

    for (const file of e.files) {
        if (files.find((f) => f.name === file.name)) {
            continue;
        }

        files.push(file);
    }

    model.value = files;
};

const onFileRemove = (e: FileUploadRemoveEvent) => {
    model.value = model.value?.filter((f) => f.name !== e.file.name);
};

const onFileClear = () => {
    model.value = [];
};

const formatSize = (bytes: number) => {
    const k = 1024;
    const dm = 3;
    const sizes = ($primevue.config.locale as any).fileSizeTypes;

    if (bytes === 0) {
        return `0 ${sizes[0]}`;
    }

    const i = Math.floor(Math.log(bytes) / Math.log(k));
    const formattedSize = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));

    return `${formattedSize} ${sizes[i]}`;
};
</script>

<template>
    <FormControl :label="label" :name="name" :required="required" :error="error">
        <template #default="{ invalid }">
            <PrimeFileUpload
                :id="name"
                :name="name"
                :size="size"
                fluid
                :placeholder="placeholder"
                :disabled="disabled"
                :readonly="readonly"
                :invalid="invalid"
                :accept="accept"
                :max-file-size="maxFileSize"
                custom-upload
                :show-upload-button="false"
                :multiple="true"
                :file-limit="fileLimit"
                choose-label="Seleziona"
                cancel-label="Rimuovi"
                @select="onFileSelect"
                @remove="onFileRemove"
                @clear="onFileClear"
            >
                <template #empty>
                    <div class="flex flex-col items-center justify-center space-y-2 py-3 pb-2">
                        <i class="pi pi-cloud-upload !text-4xl !text-muted-color" />
                        <p class="text-muted-color">Trascina i file qui per caricare.</p>
                    </div>
                </template>

                <template #content="{ files, removeFileCallback }">
                    <div class="divide-y">
                        <div
                            v-for="(file, index) of files"
                            :key="file.name + file.type + file.size"
                            class="flex w-full min-w-0 items-center gap-4 py-2"
                        >
                            <div class="flex-shrink-0">
                                <i class="pi pi-file text-xl" />
                            </div>

                            <div class="flex min-w-0 flex-col gap-1">
                                <p class="truncate">{{ file.name }}</p>
                                <p class="text-sm text-muted-color">{{ formatSize(file.size) }}</p>
                            </div>

                            <div class="ms-auto flex-shrink-0">
                                <PrimeButton icon="pi pi-times" @click="removeFileCallback(index)" variant="text" rounded severity="danger" />
                            </div>
                        </div>
                    </div>
                </template>
            </PrimeFileUpload>
        </template>
    </FormControl>
</template>
