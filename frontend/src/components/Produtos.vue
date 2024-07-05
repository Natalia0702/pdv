<template>
  <div class="container mt-4">
    <div class="form-group centered-form-group">
      <label for="selectTipoProduto" class="mr-2">Selecione o Tipo de Produto:</label>
      <select class="form-control" id="selectTipoProduto"  v-model="tipo_produto_id">
          <option disabled selected>Selecione um tipo de produto</option>
          <option v-for="tipoProduto in tiposProdutos" :key="tipoProduto.id" :value="tipoProduto.id">{{ tipoProduto.nome }}</option>
      </select>
    </div>
    <div class="row mb-3">
      <div class="col">
        <input type="text" class="form-control" v-model="nome" placeholder="Nome do Produto">
      </div>
    </div>
    <div class="row mb-3">
      <div class="col">
        <input type="text" class="form-control" v-model="preco_custo" placeholder="Preço de Custo">
      </div>
      <div class="col">
        <input type="text" class="form-control" v-model="preco_venda" placeholder="Preço de Venda">
      </div>
    </div>
    <div class="row">
      <div class="col">
        <button class="btn btn-primary" @click="sendData">Adicionar</button>
      </div>
    </div>
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
      tipo_produto_id: null,
      tiposProdutos: []
    };
  },
  mounted() {
    axios.get('http://localhost:8080/listarTiposDeProdutos').then(response => {        
        this.tiposProdutos = response.data;
      }).catch(error => {
          console.log("Erro ao carregar dados do produto" + error);
    })    
  },
  methods: {
    async sendData() {
      try {
        await axios({  
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
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>

<style>

</style>