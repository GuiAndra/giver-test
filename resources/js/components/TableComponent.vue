<template>
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
            }
        },
        mounted() {
            this.getCustomers();
        }
    }
</script>