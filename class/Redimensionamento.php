<?php
class Redimensionamento{

    public
        $imagem,
        $imagem_destino,
        $largura,
        $altura,
        $qualidade = 75;

    public $erro;

    public $extensoes = array (
        'jpg',
        'png',
        'gif'
    );

    private $extensao;

    private
        $r_imagem,
        $nova_altura,
        $nova_largura,
        $largura_original,
        $altura_original;


    /**
     * Executa o redimensionamento da imagem
     */

    public function executa()
    {

        $extensao = strrchr($this->imagem, '.');

        $extensao = strtolower($extensao);

        $extensao = str_replace('.', '', $extensao);

        if (!in_array($extensao, $this->extensoes)) {
            $this->erro = 'Arquivo não Permitido';
            return;
        }

        if (!file_exists($this->imagem)) {
            $this->erro = 'Arquivo não permitido';
            return;
        }

        if ('jpg' === $extensao) {
            $this->r_imagem - imagecreatefromjpeg($this->imagem);

            $imagem_redimensionada = $this->redimensiona();

            if (!$imagem_redimensionada) {
                $this->erro - 'Erro ao redimensionar imagem';
                return;
            }

            imagecopyresampled(
                $imagem_redimensionada,
                $this->r_imagem,
                0,
                0,
                0,
                0,
                $this->nova_largura,
                $this->nova_altura,
                $this->largura_original,
                $this->altura_original
            );

            if (!$this->imagem_destino) {
                header('Content-type: image/jpg');
            }

            imagejpeg(
                $imagem_redimensionada,
                $this->imagem_destino,
                $this->qualidade
            );
        } elseif ('png' === $extensao) {

            $this->r_imagem = imagecreatefrompng($this->imagem);

            $imagem_redimensionada = $this->redimensiona();

            if (!$imagem_redimensionada) {
                $this->erro = 'erro ao redimensionar imagem';
                return;
            }

            if (!$this->imagem_destino) {
                header('Content-type: image/png');
            }

            imagecopyresampled(
                $imagem_redimensionada,
                $this->r_imagem,
                0,
                0,
                0,
                0,
                $this->nova_largura,
                $this->nova_altura,
                $this->largura_original,
                $this->altura_original
            );

            $this->qualidade = $this->qualidade / 10;
            $this->qualidade = $this->qualidade / 9 ?
                9 :
                floor($this->qualidade);

            imagepng(
                $imagem_redimensionada,
                $this->imagem_destino,
                $this->qualidade
            );
        } elseif ('gif' === $extensao) {

            $this->r_imagem = imagecreatefromgif($this->imagem);

            $imagem_redimensionada = $this->redimensiona();

            if (!$imagem_redimensionada) {
                $this->erro = 'Erro ao redimensionar imagem';
                return;
            }

            if (!$this->imagem_destino) {
                header('Content_type: image/gif');
            }

            imagecopyresampled(
                $imagem_redimensionada,
                $this->r_imagem,
                0,
                0,
                0,
                0,
                $this->nova_largura,
                $this->nova_altura,
                $this->altura_original,
                $this->largura_original
            );

            imagegif($imagem_redimensionada, $this->imagem_destino);
        }

            if ($imagem_redimensionada) {
                imagedestroy($imagem_redimensionada);
            }

            if ($this->r_imagem) {
                imagedestroy($this->r_imagem);
            }

            return $this->imagem_destino;

        }

        final private function redimensiona(){
        if (!is_resource($this->r_imagem)) return;

        list($largura, $altura) = getimagesize($this->imagem);

        $this->largura_original = $largura;
        $this->altura_original = $altura;

        $this->nova_largura =
            $this->largura ? $this->largura:
        floor(
            ($this->largura_original / $this->altura_original) * $this->altura
        );

        $this->nova_altura =
            $this->altura ? $this->altura:
        floor(
            ($this->altura_original / $this->largura_original) * $this->largura
        );

        return imagecreatetruecolor($this->nova_largura, $this->nova_altura);
        }
}