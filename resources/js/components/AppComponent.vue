<template>
    <div>
        <v-app>
            <v-main>
                <v-container fluid class="grey lighten-5">
                    <v-row>
                        <v-col>
                            <v-img src="/images/giver.svg" height="80" contain></v-img>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="12" sm="12" md="4">
                            <v-card
                                elevation="2"
                                outlined>
                                <v-card-title>Clientes Com/Sem Sobrenome</v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <v-card
                                elevation="2"
                                outlined>
                                <v-card-title>Clientes com Email Válido/Inválido</v-card-title>
                            </v-card>
                        </v-col>
                        <v-col cols="12" sm="12" md="4">
                            <v-card
                                elevation="2"
                                outlined>
                                <v-card-title>Clientes com Gênero Válido/Invalido</v-card-title>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-btn color="blue-grey" class="white--text float-right" @click="showInputFile = !showInputFile">Importar</v-btn>
                        </v-col>
                    </v-row>
                    <v-row v-if="showInputFile">
                        <v-col sm="12" md="4" offset-md="8">
                            <v-file-input accept=".csv" label="Escolher arquivo..." show-size small-chips @change="selectFile"></v-file-input>
                            <v-btn class="primary float-right" @click="submitFile">Enviar</v-btn>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-data-table
                                :headers="headers"
                                :items="customers"
                                hide-default-footer
                                :loading="loading"
                                disable-sort
                                class="elevation-1">
                                

                            </v-data-table>
                            <div class="text-center pt-2">
                                <v-pagination
                                    v-model="pagination.page"
                                    :length="pagination.total"
                                    total-visible="7"
                                    :disabled="loading"
                                    @input="getCustomers()"
                                ></v-pagination>
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </v-app>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                customers: [],
                headers: [
                    { text: 'Nome', value: 'first_name' },
                    { text: 'Sobrenome', value: 'last_name' },
                    { text: 'Email', value: 'email' },
                    { text: 'IP', value: 'ip_address' },
                    { text: 'Empresa', value: 'company' },
                    { text: 'Cidade', value: 'city' },
                    { text: 'Título', value: 'title' },
                ],
                pagination: {
                    page: 1,
                    total: 0
                },
                loading: true,
                showInputFile: false,
                file: null
            }
        },
        methods: {
            getCustomers() {
                this.loading = true;
                axios.get('/api/customers?page=' + this.pagination.page)
                    .then(response => {
                        this.customers = response.data.data;
                        this.pagination.page = response.data.current_page;
                        this.pagination.total = response.data.last_page;
                        this.loading = false;
                    });
            },
            submitFile() {
                const formData = new FormData();
                formData.append('file', this.file);
                const headers = { 'Content-Type': 'multipart/form-data' };
                axios.post('/api/customers/import', formData, { headers }).then((res) => {
                    console.log(res)
                });
            },
            selectFile(file) {
                this.file = file;
            },
        },
        mounted() {
            this.getCustomers();
        }
    }
</script>
