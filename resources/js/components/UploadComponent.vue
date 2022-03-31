<template>
    <div>
        <v-dialog
            v-model="dialog"
            width="600px"
            >
            <v-card>
                <v-card-title>
                    <span class="text-h5">Erro ao importar o arquivo CSV</span>
                </v-card-title>
                <v-card-text>
                    <div v-for="(v, k) in errors" :key="k">
                        <p v-for="error in v" :key="error" class="text-sm">
                            {{ error }}
                        </p>
                    </div>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey darken-1"
                        text
                        v-if="showForce"
                        @click="dialogForce = true"
                    >
                        Forçar importação
                    </v-btn>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="closeErrors()"
                    >
                        OK
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="dialogForce"
            width="600px"
            >
            <v-card>
                <v-card-title>
                    <span class="text-h5">Forçar importação</span>
                </v-card-title>
                <v-card-text>
                    <p>Tem certeza que deseja forçar a importação?</p>
                    <p>Essa ação irá remover os emails e ips inválidos e importar os clientes.</p>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="grey darken-1"
                        text
                        @click="dialogForce = false"
                    >
                        Fechar
                    </v-btn>
                    <v-btn
                        color="green darken-1"
                        text
                        @click="forceImport()"
                    >
                        Sim
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-row>
            <v-col>
                <v-btn color="blue-grey" class="white--text float-right" @click="showInputFile = !showInputFile">Importar</v-btn>
            </v-col>
        </v-row>
        <v-row v-if="showInputFile">
            <v-col sm="12" md="4" offset-md="8">
                <v-file-input accept=".csv" label="Escolher arquivo..." show-size small-chips @change="selectFile"></v-file-input>
                <v-btn class="primary float-right" @click="submitFile" :loading="uploading">Enviar</v-btn>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showInputFile: false,
                file: null,
                uploading: false,
                errors: null,
                dialog: false,
                showForce: false,
                dialogForce: false
            }
        },
        methods: {
            submitFile(event, forceImport = false) {

                this.uploading = true
                
                const formData = new FormData()
                formData.append('file', this.file)

                if(forceImport) {
                    formData.append('force', forceImport)
                }

                const headers = { 'Content-Type': 'multipart/form-data' };
                
                axios.post('/api/customers/import', formData, { headers }).then((res) => {
                    this.$emit('uploadedCSV')
                    this.uploading = false
                }).catch(e => {
                    this.uploading = false
                    let errors = e.response.data.errors
                    
                    this.errors = errors

                    if(!errors.hasOwnProperty('file')) {
                        this.showForce = true
                    }

                    this.dialog = true
                });
            },
            forceImport(event) {
                this.closeErrors()
                this.submitFile(event, true)
            },
            closeErrors() {
                this.dialogForce = false
                this.errors = null
                this.dialog = false
            },
            selectFile(file) {
                this.file = file;
            },
        },
    }
</script>