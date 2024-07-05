<template> 
    <div class="container mt-4">
      <div v-if="salvoComSucesso" class="alert alert-success" role="alert">
        Produto salvo com sucesso!
      </div>
      <div v-if="deletadoComSucesso" class="alert alert-success" role="alert">
        Produto deletado com sucesso!
      </div>
        <table class="table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Preço de Custo</th>
              <th>Preço de Venda</th>
              <th>Tipo</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="produto in produtos" :key="produto.id">
                <td>
                    <span v-if="!produto.editando">{{ produto.nomeproduto }}</span>
                    <input v-else v-model="produto.nomeproduto" />
                  </td>
                  <td>
                    <span v-if="!produto.editando">{{ produto.preco_custo }}</span>
                    <input v-else v-model="produto.preco_custo" />
                  </td>
                  <td>
                    <span v-if="!produto.editando">{{ produto.preco_venda }}</span>
                    <input v-else v-model="produto.preco_venda" />
                  </td>
                  <td>
                    <span v-if="!produto.editando">{{ produto.nometipoproduto }}</span>
                    <select v-else v-model="produto.tipo_produto_id">
                        <option value="1">Fruta</option>
                        <option value="2">Legumes</option>
                        <option value="3">Verdura</option>
                        <option value="4">Carne</option>
                        <option value="5">Laticínios</option>
                        <option value="6">Bebidas</option> 
                    </select>
                  </td>
              <td>
                <div class="btn-group" role="group" aria-label="Opções">
                    <button v-if="!produto.editando" type="button" class="btn btn-primary" @click="produto.editando = true">Editar</button>
                    <template v-else>
                        <button type="button" class="btn btn-success" @click="salvarProduto(produto)">Salvar</button>
                    </template>
                    <button type="button" class="btn btn-danger" @click="deletarProduto(produto.id_produto)">Deletar</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>    
</template>

<script>
import axios from 'axios';

export default {
    // name: ListarProdutos,
    data() {
      return {
          produtos: [],
          salvoComSucesso: false,
          deletadoComSucesso: false
      }        
    },
    mounted() {
      this.carregarProdutos();
    },
    watch: {
      salvoComSucesso: function(){
        if(this.salvoComSucesso){
          setTimeout(() => {
            this.salvoComSucesso = false;
          }, 3000);
          this.carregarProdutos();
        }
      },
      deletadoComSucesso: function(){
        if(this.deletadoComSucesso){
          setTimeout(() => {
            this.deletadoComSucesso = false;
          }, 3000);
          this.carregarProdutos();
        }
      }
    },
    methods: {
      async salvarProduto(produto){
        try {
          const id = produto.id_produto;
          const response = await axios({  
            method: 'put',
            url: 'http://localhost:8080/atualizarProduto/' + id,
            data: {  
              id: produto.id_produto,   
              nome: produto.nomeproduto,
              preco_custo: produto.preco_custo,
              preco_venda: produto.preco_venda,
              tipo_produto_id: Number(produto.tipo_produto_id),
            },
            headers: {
              'Content-Type': 'application/json'
          }          
        });
          produto.editando = true; 
          if(response.data){
            this.salvoComSucesso = true;
          }
          produto.editando = false;
        } catch (error) {
          console.error(error);
        }
      },
      deletarProduto(id) {
        axios.delete(`http://localhost:8080/deletarProduto/${id}`).then( () => {
            this.deletadoComSucesso = true;
            this.carregarProdutos();
        }).catch(error => {
            console.log("Erro ao excluir produto" + error);
        })
        this.deletadoComSucesso = false;
      },
      carregarProdutos(){
        axios.get('http://localhost:8080/listarProdutos').then(response => {
            this.produtos = response.data;
            this.produtos.editando = false;
        }).catch(error => {
            console.log("Erro ao carregar dados do produto" + error);
        })
      }
    }
}
</script>

<style>

</style>