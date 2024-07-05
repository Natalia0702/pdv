<template>
    <div>
        <div class="container mt-4">
            <div v-if="salvoComSucesso" class="alert alert-success" role="alert">
                Venda salva com sucesso!
            </div>
            <div class="row">
                <div>
                    <div class="form-group centered-form-group">
                        <label for="selectCidade" class="mr-2">Selecione o Produto:</label>
                        <select class="form-control" id="selectProduto"  v-model="produtoSelecionado">
                            <option disabled selected>Selecione um produto</option>
                            <option v-for="produto in produtos" :key="produto.id" :value="produto">{{ produto.nomeproduto + ' - ' +  produto.nometipoproduto}}</option>
                        </select>
                    </div>                
                </div>
                <div class="col-md-2 mb-3">
                    <label>Quantidade</label>
                    <input v-model="quantidadeInformada" type="text" class="form-control" aria-label="Amount (to the nearest dollar)">
                </div>
                <div class="col-md-2 mb-3">
                    <label for="readonlyValor">Valor Item:</label>
                    <input type="hidden" v-if="total !== 0" v-model="total" />
                    <label type="text" class="form-control" id="readonlyValor" readonly>{{ valorItem }} </label>
                </div> 
                <div class="col-md-2 mb-3">
                    <label for="readonlyValor">Imposto:</label>
                    <label type="text" class="form-control" id="readonlyValor" readonly>{{ produtoSelecionado.percentual_imposto }} </label>
                </div> 
                <div class="col-md-2 mb-3">
                    <label for="readonlyValor">Total:</label>
                    <label type="text" class="form-control" id="readonlyValor" readonly>{{ total }} </label>
                </div>
                <div class="col-md-1 mb-2" >  
                    <button type="button" style="margin-top:32px" class="btn btn-primary" v-if="total" @click="adicionarVenda()">Adicionar</button>
                </div> 
            </div>
        </div>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Produto</th>
                        <th scope="col">Quantidade</th>
                        <th scope="col">Valor Total com Imposto</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="venda, index in vendas" :key="index">
                        <td>{{ venda.produto.nomeproduto }} - {{ venda.produto.nometipoproduto }}</td>
                        <td>{{ venda.quantidade }}</td>
                        <td>{{ venda.total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div v-if="vendas.length !== 0">
            <div v-if="vendas.length !== 0">
                <div class="row mb-3">
                    <div class="col-md-4 mb-4">
                        <label></label>
                        <label></label>
                    </div> 
                    <div class="col-md-4 mb-4">
                        <label for="readonlyValor" style="font-weight:bold">Total Valor Imposto:</label>
                        <label type="text" class="form-control" id="readonlyValor" readonly>{{ totalImpostos }} </label>
                    </div>
                    <div class="col-md-4 mb-4">
                        <label for="readonlyValor" style="font-weight:bold">Total Valor Compra:</label>
                        <label type="text" class="form-control" id="readonlyValor" readonly>{{ totalVendas }} </label>
                    </div> 

                </div>
            </div>
        
            <div class="buttons-container" v-if="vendas.length !== 0">
                <button class="button" @click="cancelarVenda()">Cancelar Venda</button>
                <button class="button" @click="salvarVenda()">Finalizar Venda</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "VendasVue",
    data() {
        return {
            produtos: [],
            produtoSelecionado: '',
            quantidadeInformada: 0,
            valorItem: '',
            total: 0,
            vendas: [],
            totalVendas: 0,
            totalImpostos: 0,
            salvoComSucesso: false,
        }        
    },
    mounted() {
        this.listarProduto()
    },
    watch: {
        produtoSelecionado: {
            handler: function() {
                this.calcularTotal();
            },
            deep: true
        },
        quantidadeInformada: function() {
            this.calcularTotal();
        },
        salvoComSucesso: function(){
        if(this.salvoComSucesso){
          setTimeout(() => {
            this.salvoComSucesso = false;
          }, 3000);
        }
      },
    },
    methods: {
        calcularTotal() {
            const valorItem = Number(this.produtoSelecionado.preco_venda) * Number(this.quantidadeInformada);
            const imposto = (valorItem * this.produtoSelecionado.percentual_imposto) / 100;
            const totalComImposto = valorItem + (imposto * this.quantidadeInformada);
            
            this.total = totalComImposto;
            this.valorItem = valorItem;
            this.valorImposto = imposto;
        },
        adicionarVenda: function() {
            this.vendas.push({
                produto: this.produtoSelecionado,
                quantidade: this.quantidadeInformada,
                total: this.total,
                total_imposto_item: this.totalImpostos
            });
            this.totalVendas = this.vendas.reduce((acc, venda) => acc + venda.total, 0);
            this.totalImpostos = this.vendas.reduce((acc, venda) => acc + ((Number(venda.produto.percentual_imposto) * Number(venda.quantidade) * Number(venda.produto.preco_venda))/100), 0);
        },
        listarProduto(){
            axios.get('http://localhost:8080/listarProdutosTipoProduto').then(response => {
                this.produtos = response.data;
            }).catch(error => {
                console.log("Erro ao carregar dados do produto" + error);
            })
        },
        cancelarVenda() {
            this.vendas = [];
            this.totalVendas = 0;
            this.totalImpostos = 0; 
            this.produtoSelecionado = ''; 
            this.quantidadeInformada = 0; 
            this.valorItem = ''; 
            this.total = 0; 

            this.listarProduto();
        },
        async salvarVenda(){
            try {
                const response = await axios({  
                method: 'post',
                url: 'http://localhost:8080/salvarVenda',
                data: {     
                    vendas: this.vendas,
                    totalVendaImposto: this.totalImpostos,
                    totalValorVenda: this.totalVendas
                },
                headers: {
                    'Content-Type': 'application/json'
                }          
                });
                console.log(response.data);
                this.salvoComSucesso = true;
            } catch (error) {
                console.error(error);
            }
            // this.salvoComSucesso = false;
        }
        
    }
}
</script>

<style>
.custom-select {
    width: 50%; /* ou qualquer valor desejado */
  }
</style>