
CREATE VIEW [dbo].[Equipamentos_reservados_N]
AS
SELECT      dbo.TB02018.TB02018_CODIGO AS ORCAMENTO,
			dbo.TB02018.TB02018_DATA AS DATAORCAMENTO,
			dbo.TB02018.TB02018_CODCLI AS CODCLIENTE,
			dbo.TB01008.TB01008_NOME AS CLIENTE,
			dbo.TB01006.TB01006_NOME AS VENDEDOR,
			dbo.TB01021.TB01021_NOME AS STATUSPEDIDO,
			dbo.TB02019.TB02019_PRODUTO AS CODPRODUTO,
			dbo.TB01010.TB01010_NOME AS PRODUTO,
			TB01010_REFERENCIA as REFERENCIA, 
            dbo.TB02055.TB02055_NUMSERIE AS SERIAL,
			dbo.TB02054.TB02054_STATUS AS STATUS,
			dbo.TB01096.TB01096_NOME AS STATUS_EQUIPAMENTO,
			dbo.TB02115.TB02115_CODIGO AS OS,
			dbo.TB02115.TB02115_DATA AS DATAOS,
			dbo.TB02115.TB02115_STATUS AS CODSTATUSOS,
			dbo.TB01073.TB01073_NOME AS STATUSOS,
			dbo.TB02115.TB02115_DTALT AS DATAMOV, 
            dbo.TB02054.TB02054_LOCSER AS LOCAL,
			TB02054_PONTUACAO AS PONTUACAO,
			TB02054_TIPOCON AS TIPO,
			TB02054_MEDIDORPB AS MEDIDORPB,
			TB02054_MEDIDORCOLOR AS MEDIDORCOLOR,
			TB02054_MEDIDORTOTAL AS MEDIDORTOTAL,
			TB02054_CUSTO AS CUSTOSERIAL,
			TB02054_OBS AS OBS, 
			TB02018_OBS AS OBSPEDIDO, 
			TB02018_OBSINT AS OBSINTERNA, 
			TB01022_NOME AS OPERACAO, 
			TB01068_NOME AS CLASSIFICACAO, 
			TB01009_NOME AS TRANSPORTADORA,
		    (select top 1 TB02002_NCONTEINER from TB02003 LEFT JOIN TB02055 AS COMPRAS ON (COMPRAS.TB02055_CODIGO = TB02003.TB02003_CODIGO AND COMPRAS.TB02055_PRODUTO = TB02019.TB02019_PRODUTO AND COMPRAS.TB02055_TABELA = 'TB02002') LEFT JOIN TB02002 ON TB02002_CODIGO = TB02003_CODIGO WHERE TB02002_NESTOQUE = 'N' AND COMPRAS.TB02055_NUMSERIE = TB02054_NUMSERIE ORDER BY TB02002_DTENTRADA DESC)  AS CONTAINER, 
			(select top 1 TB02002_DATA from TB02003 LEFT JOIN TB02055 AS COMPRAS ON (COMPRAS.TB02055_CODIGO = TB02003.TB02003_CODIGO AND COMPRAS.TB02055_PRODUTO = TB02019.TB02019_PRODUTO AND COMPRAS.TB02055_TABELA = 'TB02002') LEFT JOIN TB02002 ON TB02002_CODIGO = TB02003_CODIGO WHERE TB02002_NESTOQUE = 'N' AND COMPRAS.TB02055_NUMSERIE = TB02054_NUMSERIE ORDER BY TB02002_DTENTRADA DESC)  AS DATAPREVISAO, TB01047_NOME AS MARCA,
			TB02019_PRUNIT AS VALORUNITARIO, 
			TB02019_TOTVALOR / TB02019_QTPROD AS VALORTOTAL, 
			TB02019_VLRFRETE / TB02019_QTPROD AS VALORFRETE, 
			TB02019_VLROUTDESP / TB02019_QTPROD AS VALORDESPESAS, 
			TB02018_DTVALIDADE as VALIDADE, 
			TB02054_CODEMP AS EMPRESA, 
			TB02130_DATA AS DATAMOVOS, 
			TB02019_VLRIPI AS VALORIPI, 
			TB02054_FATOR AS FATOR,
			dbo.TB02018.TB02018_CLATENDE AS CODCLASSIFICACAO
FROM            dbo.TB02019 LEFT OUTER JOIN
                         dbo.TB02018 ON dbo.TB02019.TB02019_CODIGO = dbo.TB02018.TB02018_CODIGO LEFT OUTER JOIN
                         dbo.TB01010 ON dbo.TB01010.TB01010_CODIGO = dbo.TB02019.TB02019_PRODUTO LEFT JOIN
						 TB01047 ON TB01047_CODIGO = TB01010_MARCA LEFT JOIN
                         dbo.TB02055 ON dbo.TB02055.TB02055_CODIGO = dbo.TB02018.TB02018_CODIGO AND dbo.TB02055.TB02055_PRODUTO = dbo.TB02019.TB02019_PRODUTO AND 
                         dbo.TB02055.TB02055_TABELA = 'TB02018' LEFT OUTER JOIN
                         dbo.TB02054 ON dbo.TB02054.TB02054_PRODUTO = dbo.TB02019.TB02019_PRODUTO AND dbo.TB02054.TB02054_NUMSERIE = dbo.TB02055.TB02055_NUMSERIE AND 
                         dbo.TB02054.TB02054_CODEMP = dbo.TB02055.TB02055_CODEMP LEFT OUTER JOIN
                         dbo.TB01096 ON dbo.TB01096.TB01096_CODIGO = dbo.TB02054.TB02054_STATUS LEFT OUTER JOIN
                         dbo.TB02115 ON dbo.TB02115.TB02115_PRODUTO = dbo.TB02019.TB02019_PRODUTO AND dbo.TB02115.TB02115_NUMSERIE = dbo.TB02055.TB02055_NUMSERIE AND dbo.TB02115.TB02115_DTFECHA IS NULL 
                         LEFT OUTER JOIN
                         dbo.TB01073 ON dbo.TB01073.TB01073_CODIGO = dbo.TB02115.TB02115_STATUS LEFT OUTER JOIN
                         dbo.TB01008 ON dbo.TB01008.TB01008_CODIGO = dbo.TB02018.TB02018_CODCLI LEFT OUTER JOIN
                         dbo.TB01006 ON dbo.TB01006.TB01006_CODIGO = dbo.TB02018.TB02018_VEND LEFT OUTER JOIN
                         dbo.TB01021 ON dbo.TB01021.TB01021_CODIGO = dbo.TB02018.TB02018_STATUS  LEFT OUTER JOIN
						 dbo.TB01022 ON dbo.TB01022.TB01022_CODIGO = dbo.TB02018.TB02018_TIPODESC LEFT OUTER JOIN
						 dbo.TB01009 ON dbo.TB01009.TB01009_CODIGO = dbo.TB02018.TB02018_TRANSP LEFT OUTER JOIN
						 dbo.TB01068 ON dbo.TB01068.TB01068_CODIGO = dbo.TB02018.TB02018_CLATENDE --LEFT OUTER JOIN
						 --TB02055 AS COMPRAS ON (COMPRAS.TB02055_CODIGO = TB02019.TB02019_CODIGO AND COMPRAS.TB02055_NUMSERIE = TB02055.TB02055_NUMSERIE AND COMPRAS.TB02055_PRODUTO = TB02019.TB02019_PRODUTO AND COMPRAS.TB02055_TABELA = 'TB02002')
						 --LEFT JOIN TB02002 ON TB02002_CODIGO = COMPRAS.TB02055_CODIGO AND TB02002_NESTOQUE = 'N'

						  LEFT JOIN TB02130 ON TB02130_CODIGO = TB02115_CODIGO AND TB02130_TIPO = 'O' AND TB02130_STATUS = TB02115_STATUS AND TB02130_CODEMP = '00'

WHERE  (dbo.TB02055.TB02055_TABELA = 'TB02018') AND (TB02019_QTPROD > 0) AND (dbo.TB01010.TB01010_TIPOSUP = '9' OR dbo.TB01010.TB01010_TIPOSUP = '11')


GO


