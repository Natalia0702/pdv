<template>
    <div>
        <div class="container">
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
                    <!-- <input type="text" class="form-control" id="readonlyValor" placeholder="5" readonly>-->
                    <!-- <label type="text" class="form-control" id="readonlyValor" readonly>{{ Number(produtoSelecionado.preco_venda) * Number(quantidadeInformada) }} </label> -->
                    <input type="hidden" v-if="total !== 0" v-model="total" />
                    <label type="text" class="form-control" id="readonlyValor" readonly>{{ valorItem }} </label>
                </div> 
                <div class="col-md-2 mb-3">
                    <label for="readonlyValor">Imposto:</label>
                    <!-- <input type="text" class="form-control" id="readonlyValor" placeholder="5" readonly>-->
                    <label type="text" class="form-control" id="readonlyValor" readonly>{{ produtoSelecionado.percentual_imposto }} </label>
                </div> 
                <div class="col-md-2 mb-3">
                    <label for="readonlyValor">Total:</label>
                    <!-- <input type="text" class="form-control" id="readonlyValor" placeholder="5" readonly>-->
                    <label type="text" class="form-control" id="readonlyValor" readonly>{{ total }} </label>
                    <button v-if="total" @click="adicionarVenda()">Adicionar</button>
                </div> 
                
                {{ produtoSelecionado }}  
                {{ quantidadeInformada }}                          
            </div>
        </div>
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Valor Total com Imposto</th>
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
            vendas: []
        }        
    },
    mounted() {
        axios.get('http://localhost:8080/listarProdutosTipoProduto').then(response => {
            console.log(response);
            this.produtos = response.data;
        }).catch(error => {
            console.log("Erro ao carregar dados do produto" + error);
        })
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
        }
    },
    methods: {
        calcularTotal() {
            const valorItem = Number(this.produtoSelecionado.preco_venda) * Number(this.quantidadeInformada);
            const imposto = (valorItem * this.produtoSelecionado.percentual_imposto) / 100;
            const totalComImposto = valorItem + imposto;

            this.total = totalComImposto;
            this.valorItem = valorItem;
            this.valorImposto = imposto;
        },
        adicionarVenda: function() {
            this.vendas.push({
                produto: this.produtoSelecionado,
                quantidade: this.quantidadeInformada,
                total: this.total
            });
        }
        
    }
}
</script>

<style>
.custom-select {
    width: 50%; /* ou qualquer valor desejado */
  }
</style>