<?php
include '../../includes/configuracoes.php';
include '../../includes/conectar.php';
include '../../includes/funcoes.php';
include '../../includes/arrays.php';
include  'phptoexcel/PHPExcel.php';

$objPHPExcel = new PHPExcel();
// Podemos definir as propriedades do documento
$objPHPExcel->getProperties()->setCreator("JC EPI's")
    ->setLastModifiedBy("JC EPI's")
    ->setTitle("Solicitação de Orçamento")
    ->setSubject("Cliente: João")
    ->setDescription("Solicitado em: 25/12/2015");

// Adicionamos um estilo de A1 até D1


$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->applyFromArray(
    array('fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFAF02')
    ),
    )
);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', 'Produto' )
    ->setCellValue('B1', "Quantidade" )
    ->setCellValue("C1", "Valor por Produto" )
    ->setCellValue("D1", "Valor Total" );

$rowex = 2;
$filterid = $_GET['id'];

$query = "SELECT * FROM ft_orcamentos WHERE id = {$filterid}";


$queryint = $query or die("Erro.." . mysqli_error($link_db));


$queryint = mysqli_query($link_db, $queryint);

while ($item = mysqli_fetch_array($queryint)) {

    $slug = $item['userslug'];
    $datahora = $item['datahora'];
    $firstarray = explode('</p><p>',$item['produtos']);
    foreach ($firstarray as &$value) {
        $secondarray = explode(':</b> ',$value);
        $prodname =  str_replace('<p>','',$secondarray[0]);
        $prodqtd =  str_replace('</p>','',$secondarray[1]);
        $prodname =  str_replace('<b>','',$prodname);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $rowex, $prodname);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $rowex, $prodqtd);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $rowex, 0);

        $objPHPExcel->getActiveSheet()->getStyle('B'.$rowex)->getNumberFormat()->setFormatCode('0');
        $objPHPExcel->getActiveSheet()->getStyle('C'.$rowex)->getNumberFormat()->setFormatCode('R$ * #,##0.00');
        $objPHPExcel->getActiveSheet()->getStyle('D'.$rowex)->getNumberFormat()->setFormatCode('R$ * #,##0.00');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $rowex, '=B'.$rowex.'*C'.$rowex);
        $rowex++;


    }

}
$objPHPExcel->getActiveSheet()->getStyle('D'.$rowex)->getNumberFormat()->setFormatCode('R$ * #,##0.00');
$objPHPExcel->getActiveSheet()->getStyle('A'.$rowex)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B'.$rowex)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C'.$rowex)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D'.$rowex)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $rowex, 'TOTAL: ');
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $rowex, '=SUM(D1:D'.($rowex-1).')');


$objPHPExcel->getActiveSheet()->getStyle('A'.$rowex.':D'.$rowex)->applyFromArray(
    array('fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFAF02')
    ),
    )
);

// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

// Também podemos escolher a posição exata aonde o dado será inserido (coluna, linha, dado);



// Exemplo inserindo uma segunda linha, note a diferença no segundo parâmetro


// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas
$objPHPExcel->getActiveSheet()->setTitle('Credenciamento para o Evento');

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');

                $dataharray = explode(' ', $datahora);
                $dataarray = explode('-', $dataharray[0]);
                $horaarray = explode(':', $dataharray[1]);


                $dia =  $dataarray[2] . '-' . $dataarray[1] . '-' . $dataarray[0].'_'.$horaarray[0].'h_'.$horaarray[1].'m';



header('Content-Disposition: attachment;filename="orcamento_'.$slug.'_'.$dia.'.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output');

exit;

?>