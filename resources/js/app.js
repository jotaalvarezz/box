require('./bootstrap')

import FileBox from './components/File'
import FolderFormBox from './components/FolderForm'
import FileFormBox from './components/FileForm'

window.feather = require('feather-icons')
window.feather.replace()

window.Vue = require('vue')

const app = new Vue({

    el: '#app',

    name: 'MyBox',

    components: {
        FileBox,
        FolderFormBox,
        FileFormBox
    },

    data() {
        return {
            rootDirectory: 'box',
            currentDirectory: 'box',
            directories: [],
            files: [],
            showFolderFormModal: false,
            showFileFormModal: false
        }
    },

    mounted() {
        this.loadFiles(this.currentDirectory)
    },

    methods: {

        loadFiles(path) {

            path = path.split('/').join('-@folder@-')
            path = path.split(' ').join('-@space@-')
            let fullpath = `/files?path=${path}`

            this.directories = []
            this.files = []
            console.log(' path -> ', path, ' fullpath -> ', fullpath)
            window.axios.get(fullpath)
                .then((response) => {
                    console.log("cargando => ", response)
                    this.directories = response.data.directories
                    this.files = response.data.files

                })
        },

        changeDirectory(directory) {
            this.currentDirectory = directory
            this.loadFiles(this.currentDirectory)
        },

        goRoot() {
            this.changeDirectory(this.rootDirectory)
        },

        goBack() {
            let temp = this.currentDirectory.split('/')
            temp.splice(temp.length - 1, 1)

            let previousDirectory = temp.join('/')

            if (this.currentDirectory != this.rootDirectory) {

                this.changeDirectory(previousDirectory)

            }
        }

    }
})