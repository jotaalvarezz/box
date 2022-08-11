<template>
    <div class="modal-file">

        <div class="modal-file-back" @click="closeForm"></div>
        <div class="modal-file-front">

            <div class="title">Subir Archivos</div>

            <input
                class="input"
                ref="fileFormInput"
                type="file"
                @change="fileSelected"
                placeholder="Archivo"
                multiple>

            <button
                :disabled="!canUploadFiles"
                class="action-button green"
                type="button"
                @click="saveFile">
                <save-icon size="1.5x"></save-icon>
                <span>Guardar</span>
            </button>

            <button
                class="action-button orange"
                type="button"
                @click="closeForm">
                <x-circle-icon size="1.5x"></x-circle-icon>
                <span>Cancelar</span>
            </button>

        </div>
    </div>
</template>

<script>

    import {
        SaveIcon,
        XCircleIcon } from 'vue-feather-icons'

    export default {

        name: 'FileForm',

        props: {

            directory: {
                type: String,
                required: true
            }

        },

        components: {
            SaveIcon,
            XCircleIcon
        },

        data() {
            return {
                files: []
            }
        },

        methods: {

            fileSelected(event) {
                this.files = event.target.files
            },

            saveFile() {
                let formData = new FormData()
                formData.append('type', 'file')
                formData.append('directory', this.directory);

                for (let i = 0; i < this.files.length; i++) {

                    formData.append('files[]', this.files[i]);

                }

                axios.post( '/files', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        console.log("save file => ",response)
                        this.$refs.fileFormInput.value = null;
                        this.files = []

                        this.$emit('success')
                        this.closeForm()

                    }).catch(response => {

                        console.log(response);

                    });
            },

            closeForm() {
                this.$emit('close')
            }

        },

        computed: {

            canUploadFiles() {
                return this.files.length > 0
            }

        }

    }

</script>

<style lang="scss">

    .modal-file {
        display: block;

        .modal-file-back {
            background-color: var(--color-black-transparent);
            left: 0;
            height: 100vh;
            position: fixed;
            top: 0;
            width: 100vw;
            z-index: 500;
        }

        .modal-file-front {
            align-items: stretch;
            background-color: var(--color-black);
            border: 3px solid var(--color-gray);
            border-radius: 1rem;
            display: flex;
            flex-flow: column nowrap;
            left: 50%;
            padding: 1rem;
            position: fixed;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            z-index: 600;

            &>* {
                margin: 0.5rem 0;
            }

            .title {
                color: var(--color-gray);
                margin-bottom: 1rem;
                margin-top: 0;
                padding: 0.5rem 0;
            }

            .input {
                border: 0;
                border-radius: 0.3rem;
                color: var(--color-gray);
                padding: 0.5rem;
            }
        }

    }

</style>
