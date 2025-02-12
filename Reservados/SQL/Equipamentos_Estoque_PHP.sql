
CREATE VIEW [dbo].[Equipamentos_Estoque_PHP]
AS
SELECT
CONTAINER,
DATAPREVISAO AS DATACHEGADA,
SITUACAO AS STATUS,
MARCA,
REFERENCIA AS MODELO,
SERIAL AS SERIE,
MEDIDORPB AS PB,
MEDIDORCOLOR AS COLOR,
MEDIDORTOTAL AS TOTAL,
CUSTOSERIAL AS CUSTOSERIAL,
VALORBASE AS VALORBASE,
FATOR,
(VALORFINAL + (CASE WHEN (CUSTOSERIAL < VALORFINAL) THEN ((VALORFINAL - CUSTOSERIAL)*IPI) ELSE 0 END)) AS MINIMO,
(VALORFINAL + (VALORFINAL * (SELECT TB01045_ACRESCIMO FROM TB01045 WHERE TB01045_CODIGOX = '01' AND TB01045_CODIGOY = SUBGRUPO AND TB01045_CODEMP = EMPRESA)/100)) + (CASE WHEN (CUSTOSERIAL < VALORFINAL) THEN ((VALORFINAL - CUSTOSERIAL)*IPI) ELSE 0 END)  AS BASICO,
(VALORFINAL + (VALORFINAL * (SELECT TB01045_ACRESCIMO FROM TB01045 WHERE TB01045_CODIGOX = '02' AND TB01045_CODIGOY = SUBGRUPO AND TB01045_CODEMP = EMPRESA)/100)) + (CASE WHEN (CUSTOSERIAL < VALORFINAL) THEN ((VALORFINAL - CUSTOSERIAL)*IPI) ELSE 0 END) AS ALMEJADO,
(VALORFINAL + (VALORFINAL * (SELECT TB01045_ACRESCIMO FROM TB01045 WHERE TB01045_CODIGOX = '12' AND TB01045_CODIGOY = SUBGRUPO AND TB01045_CODEMP = EMPRESA)/100)) + (CASE WHEN (CUSTOSERIAL < VALORFINAL) THEN ((VALORFINAL - CUSTOSERIAL)*IPI) ELSE 0 END) AS PALLET,
'DISPONIVEL' AS SITUACAO,
'' AS ORCAMENTO,
'' AS CLIENTE,
'' AS VENDEDOR,
'' AS CLASSIFICACAO,
'' AS OBSPEDIDO,
CONVERT(VARCHAR(2047),OBS) AS OBSTECNICAS,
PONTUACAO AS NOTA,
NOMELOCAL AS LOCAL,
CODSTATUS AS CODSTATUS,
CODPRODUTO AS CODPRODUTO,
NULL AS CODCLASSIFICACAO,
NULL AS CODCLIENTE,
NULL AS DTCAD
FROM EQUIPAMENTOS_PARA_VENDA_N 

LEFT JOIN TB01045 ON TB01045_CODIGOY = SUBGRUPO AND TB01045_CODEMP = EMPRESA

UNION

SELECT
CONTAINER,
DATAPREVISAO AS DATACHEGADA,
STATUS_EQUIPAMENTO AS STATUS,
MARCA,
REFERENCIA AS MODELO,
SERIAL AS SERIE,
MEDIDORPB AS PB,
MEDIDORCOLOR AS COLOR,
MEDIDORTOTAL AS TOTAL,
CUSTOSERIAL AS CUSTOSERIAL,
VALORTOTAL AS VALORBASE,
FATOR,
VALORTOTAL AS MINIMO,
VALORTOTAL  AS BASICO,
VALORTOTAL AS ALMEJADO,
VALORTOTAL AS PALLET,
'DISPONIVEL' AS SITUACAO,
ORCAMENTO AS ORCAMENTO,
CLIENTE AS CLIENTE,
VENDEDOR AS VENDEDOR,
CLASSIFICACAO AS CLASSIFICACAO,
CONVERT(VARCHAR(2047),OBSPEDIDO) AS OBSPEDIDO,
CONVERT(VARCHAR(2047),OBS) AS OBSTECNICAS,
PONTUACAO AS NOTA,
LOCAL AS LOCAL,
CODSTATUSOS AS CODSTATUS,
CODPRODUTO AS CODPRODUTO,
CODCLASSIFICACAO AS CODCLASSIFICACAO,
CODCLIENTE AS CODCLIENTE,
DATAORCAMENTO AS DTCAD
FROM Equipamentos_reservados_N 


GO


