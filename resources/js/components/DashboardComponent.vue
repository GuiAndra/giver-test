<template>
    <v-row>
        <v-col align="center">
            <v-card
                elevation="2"
                max-width="344"
                outlined>
                <v-card-title>Sobrenome</v-card-title>

                <v-card-text>

                    <div v-if="lastNameData" class="pa-4">
                        <doughnut :chart-data="lastNameData" :chart-options="chartOptions"></doughnut>
                    </div>
                    <div v-else class="pl-5">
                        <p>Sem dados para exibir</p>
                    </div>
                </v-card-text>
                
            </v-card>
        </v-col>
        <v-col align="center">
            <v-card
                elevation="2"
                max-width="344"
                outlined>
                <v-card-title>Email</v-card-title>
                <div v-if="genderData" class="pa-4">
                    <doughnut :chart-data="genderData" :chart-options="chartOptions"></doughnut>
                </div>
                <div v-else class="pl-5">
                    <p>Sem dados para exibir</p>
                </div>
            </v-card>
        </v-col>
        <v-col align="center">
            <v-card
                elevation="2"
                max-width="344"
                outlined>
                <v-card-title>Gênero</v-card-title>
                <div v-if="emailData" class="pa-4">
                    <doughnut :chart-data="emailData" :chart-options="chartOptions"></doughnut>
                </div>
                <div v-else class="pl-5">
                    <p>Sem dados para exibir</p>
                </div>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
    import 'chart.js/auto';
    import { Doughnut } from 'vue-chartjs/legacy'
    
    export default {
        components: {
            Doughnut
        },
        data() {
            return {
                lastNameData: null,
                genderData: null,
                emailData: null,
                chartOptions: {
                    responsive: true
                }
            }
        },
        methods: {
            async getDashboardData() {
                let data = await axios.get('api/customers/dashboard')
                
                if (!data) return
                
                this.setLastNameData(data.data)
                this.setGenderData(data.data)
                this.setEmailData(data.data)
            },
            setLastNameData(data) {
                if(! data.total){
                    return
                }
                this.lastNameData = {
                    labels: [
                        'Válido',
                        'Inválido',
                    ],
                    datasets: [{
                        data: [data.total - data.invalidLastName, data.invalidLastName],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]
                }
            },
            setGenderData(data) {
                if(! data.total){
                    return
                }
                this.genderData = {
                    labels: [
                        'Válido',
                        'Inválido',
                    ],
                    datasets: [{
                        data: [data.total - data.invalidGender, data.invalidGender],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]
                }
            },
            setEmailData(data) {
                if(! data.total){
                    return
                }
                this.emailData = {
                    labels: [
                        'Válido',
                        'Inválido',
                    ],
                    datasets: [{
                        data: [data.total - data.invalidEmail, data.invalidEmail],
                        backgroundColor: [
                            'rgb(54, 162, 235)',
                            'rgb(255, 99, 132)',
                        ],
                        hoverOffset: 4
                    }]
                }
            },
        },
        mounted() {
            this.getDashboardData()
        }
    }
</script>