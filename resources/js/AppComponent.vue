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
                    <dashboard-component></dashboard-component>
                    <upload-component @uploadedCSV="refreshData()"></upload-component>
                    <table-component ref="tableComponent"></table-component>
                </v-container>
            </v-main>
        </v-app>
    </div>
</template>

<script>
    import DashboardComponent from './components/DashboardComponent.vue'
    import TableComponent from './components/TableComponent.vue'
    import UploadComponent from './components/UploadComponent.vue'
    
    export default {
        components: {
            'dashboard-component': DashboardComponent,
            'table-component': TableComponent,
            'upload-component': UploadComponent,
        },
        methods: {
            refreshData() {
                this.$refs.tableComponent.getCustomers()
            }
        }
    }
</script>
