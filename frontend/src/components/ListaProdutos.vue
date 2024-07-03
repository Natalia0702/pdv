<template> 
    <div>
        <h1>Lista de Produtos</h1>
        <ul>
            <li v-for="produto in produtos" :key="produto.id">
                <strong>Nome:</strong> {{ produto.nome }} <br>
                <strong>Preço de Custo:</strong> R$ {{ produto.preco_custo }} <br>
                <strong>Preço de Venda:</strong> R$ {{ produto.preco_venda }} <br>
                <strong>Tipo:</strong> {{ produto.tipo_produto_id }} <br>
            </li>
        </ul>
    </div>      
</template>

<script>
import axios from 'axios';

export default {
    // name: ListarProdutos,
    data() {
        return {
            produtos: []
        }        
    },
    mounted() {
        axios.get('http://localhost:8080/listarProdutos').then(response => {
            console.log(response);
            this.produtos = response.data;
        }).catch(error => {
            console.log("Erro ao carregar dados do produto" + error);
        })
    }
}
</script>

<style>

</style>