<?php
require_once 'Connection.php';
class ProdutoModel 
{
    private $pdo;
    private $id;
    private $nome;
    private $descricao;
    private $preco;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscar($id = null)
    {   
        if ($id === null) {
            $stmt = $this->pdo->query('SELECT p.nome as nomeProduto, tp.nome as nomeTipoProduto, p.id as id_produto, p.*, tp.* FROM produtos p join tipos_produtos tp on p.tipo_produto_id = tp.id');
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $this->pdo->prepare('SELECT * FROM produtos WHERE id = :id');
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function atualizarProduto(int $id, string $nome , float $preco_custo, float $preco_venda, int $tipo_produto_id): bool
    {   
        $stmt = $this->pdo->prepare('UPDATE produtos SET nome = :nome, preco_custo= :preco_custo, preco_venda= :preco_venda, tipo_produto_id= :tipo_produto_id WHERE id = :id');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco_custo', $preco_custo, PDO::PARAM_INT);
        $stmt->bindParam(':preco_venda', $preco_venda, PDO::PARAM_INT);
        $stmt->bindParam(':tipo_produto_id', $tipo_produto_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        try{
            $stmt->execute();
            echo 'Produto editado com sucesso!';
            return true;
        }catch(PDOException $e){
            echo "Erro ao executar UPDATE: ". $e->getMessage();
            return false;
        }
    }

    public function criarProduto($nome, $preco_custo, $preco_venda, $tipo_produto_id): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO produtos (nome, preco_custo, preco_venda, tipo_produto_id) VALUES (:nome, :preco_custo, :preco_venda, :tipo_produto_id)');
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':preco_custo', $preco_custo, PDO::PARAM_INT);
        $stmt->bindParam(':preco_venda', $preco_venda, PDO::PARAM_INT);
        $stmt->bindParam(':tipo_produto_id', $tipo_produto_id, PDO::PARAM_STR);
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erro ao executar INSERT: " . $e->getMessage();
            return false;
        }
    }

    public function deletarProduto(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM produtos WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erro ao executar DELETE: " . $e->getMessage();
            return false;
        }
    }

    public function listarProdutosTipoProduto()
    {
        $stmt = $this->pdo->query("SELECT p.*, tp.*, tp.nome as nomeTipoProduto, p.nome as nomeProduto FROM produtos p JOIN tipos_produtos tp ON p.tipo_produto_id = tp.id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTiposDeProdutos(){
        $stmt = $this->pdo->query("SELECT * FROM TIPOS_PRODUTOS");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);            
    }
    public function salvarVenda($data){
        try {
            $this->pdo->beginTransaction();

            $stmtVenda = $this->pdo->prepare('INSERT INTO vendas (data_venda, total_compra, total_imposto) VALUES (NOW(), :total, :totalImpostos)');
            $stmtVenda->bindParam(':total', $data->totalValorVenda, PDO::PARAM_INT);
            $stmtVenda->bindParam(':totalImpostos', $data->totalVendaImposto, PDO::PARAM_INT);
            $stmtVenda->execute();

            // Obter o ID da venda inserida
            $vendaId = $this->pdo->lastInsertId();
            $stmtItemVenda = $this->pdo->prepare('INSERT INTO itens_venda (id_venda, produto, quantidade, valor_total) VALUES (:id_venda, :nomeproduto, :quantidade, :total)');
            
            foreach ($data->vendas as $item) {
                $stmtItemVenda->bindParam(':id_venda', $vendaId, PDO::PARAM_INT);
                $stmtItemVenda->bindParam(':nomeproduto', $item->produto->nomeproduto, PDO::PARAM_STR);
                $stmtItemVenda->bindParam(':quantidade', $item->quantidade, PDO::PARAM_INT);
                $stmtItemVenda->bindParam(':total', $item->total, PDO::PARAM_STR);
                $stmtItemVenda->execute();
            }
            
            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            echo "Erro ao salvar venda: " . $e->getMessage();
            return false;
        }
    }
}
