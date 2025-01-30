USE [TINSEI]
GO

/****** Object:  Table [dbo].[GS_COTACOES]    Script Date: 06/12/2024 14:21:48 ******/
SET ANSI_NULLS ON
GO

SET QUOTED_IDENTIFIER ON
GO

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
	[VALORFINAL] [numeric](18, 2) NULL,
	[NUMSERIE] [varchar](30) NULL,
	[DATA] [datetime] NULL,
	[TABELA] [varchar](2) NULL,
	[OBS] [text] NULL,
	[VLREMBALAGEM] [numeric](18, 2) NULL,
	[FAIXA] [varchar](20) NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO


