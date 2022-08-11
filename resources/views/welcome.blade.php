<!DOCTYPE html>
<html lang="es_CO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>MyBox</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="files-app-wp">

    <div class="files-app" id="app">

        <folder-form-box
            v-if="showFolderFormModal"
            v-on:close="showFolderFormModal = false"
            v-on:success="changeDirectory(currentDirectory)"
            :directory="currentDirectory"></folder-form-box>

        <file-form-box
            v-if="showFileFormModal"
            v-on:close="showFileFormModal = false"
            v-on:success="changeDirectory(currentDirectory)"
            :directory="currentDirectory"></file-form-box>

        <header class="header">
            <div class="header-options">

                <button class="action-button orange" @@click="goRoot">
                    <i width="24" height="24" data-feather="home"></i>
                </button>

                <button class="action-button white" @@click="goBack" v-show="currentDirectory != rootDirectory">
                    <i width="24" height="24" data-feather="arrow-up-circle"></i>
                </button>

                <div class="space"></div>

                <button class="action-button green" @@click="showFolderFormModal = true">
                    <i width="24" height="24" data-feather="folder-plus"></i>
                </button>

                <button class="action-button green" @@click="showFileFormModal = true">
                    <i width="24" height="24" data-feather="file-plus"></i>
                </button>

            </div>
            <div class="header-path">

                <div class="path">/@{{ currentDirectory }}</div>

            </div>
        </header>

        <main class="main">
            <div class="files-container">

                <file-box
                    v-for="directory in directories" :key="directory"
                    v-on:change-directory="changeDirectory"
                    :file="directory"
                    type="directory"></file-box>

                <file-box
                    v-for="file in files" :key="file"
                    v-on:change-directory="changeDirectory"
                    :file="file"
                    type="file"></file-box>

            </div>
        </main>

    </div>

    <script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
