USE [DISTRIVISA]
GO

/****** Object:  View [dbo].[Equipamentos_Estoque_PHP]    Script Date: 29/01/2025 11:05:13 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO



ALTER VIEW [dbo].[Equipamentos_Estoque_PHP]
AS
SELECT
CONTAINER,
SITUACAO AS STATUS,
CODSITUACAO AS CODSITUACAO,
MARCA,
REFERENCIA AS MODELO,
SERIAL AS SERIE,
MEDIDORPB AS PB,
MEDIDORCOLOR AS COLOR,
MEDIDORTOTAL AS TOTAL,
CUSTOMEDIO AS CUSTOSERIAL,
VALORBASE AS VALORBASE,
FATOR,
(VALORFINAL + (CASE WHEN (CUSTOSERIAL < VALORFINAL) THEN ((VALORFINAL - CUSTOMEDIO)*IPI) ELSE 0 END))  AS VALORVENDA,
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
NULL AS DTCAD,
CASE WHEN EMPRESA = '00' THEN 'DISTRIVISA' WHEN EMPRESA = '80' THEN 'DUOTECH' ELSE 'OUTRAS' END AS EMPRESA,
CUSTOMEDIO,
'' as DATAORCAMENTO,
STATUSOS

FROM EQUIPAMENTOS_PARA_VENDA_N 

UNION

SELECT
CONTAINER,
STATUS_EQUIPAMENTO AS STATUS,
CODSITUACAO AS CODSITUACAO,
MARCA,
REFERENCIA AS MODELO,
SERIAL AS SERIE,
MEDIDORPB AS PB,
MEDIDORCOLOR AS COLOR,
MEDIDORTOTAL AS TOTAL,
customedio AS CUSTOSERIAL,
VALORTOTAL AS VALORBASE,
FATOR,
VALORTOTAL AS VALORVENDA,
'RESERVADO' AS SITUACAO,
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
DATAORCAMENTO AS DTCAD,
CASE WHEN EMPRESA = '00' THEN 'DISTRIVISA' WHEN EMPRESA = '80' THEN 'DUOTECH' ELSE 'OUTRAS' END AS EMPRESA,
CUSTOMEDIO,
DATAORCAMENTO,
STATUSOS

FROM Equipamentos_reservados_N 



GO

