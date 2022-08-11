<template>
    <div class="modal-folder">

        <div class="modal-folder-back" @click="closeForm"></div>
        <div class="modal-folder-front">

            <div class="title">Crear Carpeta</div>

            <input
                class="input"
                type="text"
                v-model="name"
                placeholder="Nombre de la carpeta">

            <button
                class="action-button green"
                :disabled="!canSummitForm"
                type="button"
                @click="saveFolder">
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

        name: 'FolderForm',

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
                name: ''
            }
        },

        methods: {

            saveFolder() {
                const data = {
                    directory: this.directory,
                    name: this.name.trim(),
                    type: 'folder'
                }

                window.axios.post('/files', data)
                    .then(response => {
                        console.log("request save => ",response)
                        this.name = ''
                        this.$emit('success')
                        this.closeForm()

                    })
                    .catch(response => {

                        this.name = ''
                        console.log(response)

                    })
            },

            closeForm() {
                this.$emit('close')
            }

        },

        computed: {

            canSummitForm() {
                if (this.name.length == 0) {

                    return false

                } else if (this.name.indexOf('-@folder@-') >= 0 || this.name.indexOf('-@space@-') >= 0) {

                    return false

                }

                return true
            }

        }

    }

</script>

<style lang="scss">

    .modal-folder {
        display: block;

        .modal-folder-back {
            background-color: var(--color-black-transparent);
            left: 0;
            height: 100vh;
            position: fixed;
            top: 0;
            width: 100vw;
            z-index: 500;
        }

        .modal-folder-front {
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
                color: var(--color-black);
                padding: 0.5rem;
            }
        }
    }

</style>
