
CREATE TABLE [dbo].[GS_COTACOES](
	[CODIGO] [varchar](6) NOT NULL,
	[CLIENTE] [varchar](max) NULL,
	[TIPOCONS] [varchar](1) NULL,
	[VENDEDOR] [varchar](max) NULL,
	[PESSOA] [varchar](1) NULL,
	[CONDICAO] [varchar](4) NULL,
	[CLASSIFICACAO] [varchar](4) NULL,
	[PRODUTO] [varchar](5) NULL,
	[REFERENCIA] [varchar](max) NULL,
	[STATUS] [varchar](max) NULL,
	[MEDIDORPB] [int] NULL,
	[MEDIDORCOLOR] [int] NULL,
	[MEDIDORTOTAL] [int] NULL,
	[VALORFINAL] [numeric](18, 0) NULL,
	[NUMSERIE] [varchar](30) NULL,
	[DATA] [datetime] NULL,
	[TABELA] [varchar](2) NULL,
	[OBS] [text] NULL,
	[VLREMBALAGEM] [numeric](18, 0) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]



ALTER TABLE GS_COTACOES
ADD OBS TEXT 

ALTER TABLE GS_COTACOES
ADD VLREMBALAGEM NUMERIC (18, 2)

ALTER TABLE GS_COTACOES
ALTER COLUMN VALORFINAL NUMERIC (18, 2)