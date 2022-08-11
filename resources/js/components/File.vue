<template>

    <div class="files-item item-file">

        <folder-icon v-if="type == 'directory'" size="3x"></folder-icon>
        <file-icon v-if="type == 'file'" size="3x"></file-icon>

        <span class="file-name">{{ file | file_format }}</span>

        <div class="files-item-option">

            <button class="action-button green" @click="showOptions = true">
                <more-vertical-icon size="1.5x"></more-vertical-icon>
            </button>

        </div>

        <div
            class="files-item-options-wp"
            :class="{ 'show' : showOptions == true }"
            @click="showOptions = false"></div>

        <div
            class="files-item-options"
            :class="{ 'show' : showOptions == true }">

            <div class="title">{{ file | file_format }}</div>

            <button v-if="type == 'directory'" class="action-button green" @click="changeDirectory(file)">
                <folder-icon size="1.5x"></folder-icon>
                <span>Abrir Carpeta</span>
            </button>

            <a v-if="type == 'file'" class="action-button green" :href="getDownloadUrl(file)">
                <download-icon size="1.5x"></download-icon>
                <span>Descargar</span>
            </a>

            <div></div>

            <button class="action-button red" @click="deleteFile(file)">
                <trash-2-icon size="1.5x"></trash-2-icon>
                <span>Borrar</span>
            </button>

            <div></div>

            <button class="action-button orange" @click="showOptions = false">
                <x-circle-icon size="1.5x"></x-circle-icon>
                <span>Cerrar</span>
            </button>

        </div>

    </div>

</template>

<script>

    import {
        FileIcon,
        FolderIcon,
        MoreVerticalIcon,
        DownloadIcon,
        Trash2Icon,
        XCircleIcon } from 'vue-feather-icons'

    export default {

        props: {
            file: {
                type: String,
                required: true
            },
            type: {
                type: String,
                required: true
            }
        },

        name: "File",

        components: {
            FileIcon,
            FolderIcon,
            MoreVerticalIcon,
            DownloadIcon,
            Trash2Icon,
            XCircleIcon
        },

        data() {
            return {
                showOptions: false
            }
        },

        methods: {

            getDownloadUrl(file) {
                return '/files/' + file.split('/').join('-@folder@-').split(' ').join('-@space@-')
            },

            changeDirectory(directory) {
                this.showOptions = false
                this.$emit('change-directory', directory)
            },

            deleteFile(file) {
                let directory = file.split('/')
                directory.splice(directory.length - 1, 1)
                directory = directory.join('/')

                axios.delete( '/files/' + file.split('/').join('-@folder@-').split(' ').join('-@space@-'))
                    .then(response => {
                        console.log("delete => ",response)
                        this.changeDirectory(directory)

                    }).catch(response => {

                        console.log(response)

                    })
            }

        },

        filters: {

            file_format(value) {
                let filename = value.split('/').reverse()[0]
                return filename
            }

        }

    }

</script>

<style lang="scss">

    .files-item {
        align-items: center;
        border-radius: 0.5rem;
        display: flex;
        flex-flow: column nowrap;
        height: auto;
        margin: 0.5rem;
        padding: 0.5rem;
        position: relative;
        width: 140px;

        .file-name {
            display: inline-block;
            margin-top: 0.5rem;
            text-align: center;
            word-wrap: break-word;
            width: 100%;
        }

        .files-item-option {
            align-items: center;
            display: flex;
            flex-flow: row nowrap;
            justify-content: flex-end;
            position: absolute;
            right: 0;
            top: 0;

            &>* {
                margin: 0;
            }

        }

        &:hover {
            background-color: var(--color-black-transparent);
            color: var(--color-green);
        }
    }

    .files-item-options-wp {
        background-color: var(--color-black-transparent);
        display: none;
        left: 0;
        height: 100vh;
        position: fixed;
        top: 0;
        width: 100vw;
        z-index: 100;

        &.show {
            display: block;
        }
    }

    .files-item-options {
        align-items: stretch;
        background-color: var(--color-black);
        border: 3px solid var(--color-gray);
        border-radius: 1rem;
        display: none;
        flex-flow: column nowrap;
        left: 50%;
        padding: 1rem;
        position: fixed;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        z-index: 200;

        &>* {
            margin: 0.5rem 0;
        }

        .title {
            color: var(--color-gray);
            margin-bottom: 1rem;
            padding: 0.5rem 0.8rem;
            word-wrap: break-word;
        }

        &.show {
            display: flex;
        }
    }

</style>
