<template>
    <div>
        <h2>Inserir Produtos </h2>
        <input type="text" v-model="nome" placeholder="Nome do Produto">        
        <input type="text" v-model="preco_custo" placeholder="Preco Custo">        
        <input type="text" v-model="preco_venda" placeholder="Preco Venda">
        <input type="text" v-model="tipo_produto_id" placeholder="Tipo Produto">
        <button @click="sendData">Enviar dados</button>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "ProdutosVue",
    data() {
    return {
      nome: '',
      preco_custo: null,
      preco_venda: null,
      tipo_produto_id: null
    };
  },
  methods: {
    async sendData() {
      try {
        
        const response = await axios({     
          method: 'post',
          url: 'http://localhost:8080/salvarProduto',
          data: {     
            nome: this.nome,
            preco_custo: this.preco_custo,
            preco_venda: this.preco_venda,
            tipo_produto_id: this.tipo_produto_id,
          },
          headers: {
            'Content-Type': 'application/json'
          }          
        });

        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>

<style>

</style>