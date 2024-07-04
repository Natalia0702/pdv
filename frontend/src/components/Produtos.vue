<template>
  <div class="container mt-4">
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
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 mb-3">
          <div class="form-group centered-form-group">
            <label for="selectCidade" class="mr-2">Selecione o Tipo do Produto:</label>
            <select class="form-control" id="selectCidade">
              <option value="1">Fruta</option>
              <option value="2">Legumes</option>
              <option value="3">Verdura</option>
              <option value="4">Carne</option>
              <option value="5">Laticínios</option>
              <option value="6">Bebidas</option> 
            </select>
          </div>
        </div>
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