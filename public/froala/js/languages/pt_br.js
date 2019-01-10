/*!
 * froala_editor v2.9.1 (https://www.froala.com/wysiwyg-editor)
 * License https://froala.com/wysiwyg-editor/terms/
 * Copyright 2014-2018 Froala Labs
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = function( root, jQuery ) {
            if ( jQuery === undefined ) {
                // require('jQuery') returns a factory that requires window to
                // build a jQuery instance, we normalize how we use modules
                // that require this pattern but the window provided is a noop
                // if it's defined (how jquery works)
                if ( typeof window !== 'undefined' ) {
                    jQuery = require('jquery');
                }
                else {
                    jQuery = require('jquery')(root);
                }
            }
            return factory(jQuery);
        };
    } else {
        // Browser globals
        factory(window.jQuery);
    }
}(function ($) {
/**
 * Portuguese spoken in Brazil
 */

$.FE.LANGUAGE['pt_br'] = {
  translation: {
    // Place holder
    "Type something": "Digite algo",

    // Basic formatting
    "Bold": "Negrito",
    "Italic": "It&#225;lito",
    "Underline": "Sublinhar",
    "Strikethrough": "Tachado",

    // Main buttons
    "Insert": "Inserir",
    "Delete": "Apagar",
    "Cancel": "Cancelar",
    "OK": "Ok",
    "Back": "Voltar",
    "Remove": "Remover",
    "More": "Mais",
    "Update": "Atualizar",
    "Style": "Estilo",

    // Font
    "Font Family": "Fonte",
    "Font Size": "Tamanho",

    // Colors
    "Colors": "Cores",
    "Background": "Fundo",
    "Text": "Texto",
    "HEX Color": "Cor hexadecimal",

    // Paragraphs
    "Paragraph Format": "Formatos",
    "Normal": "Normal",
    "Code": "C&#243;digo",
    "Heading 1": "Cabe&#231;alho 1",
    "Heading 2": "Cabe&#231;alho 2",
    "Heading 3": "Cabe&#231;alho 3",
    "Heading 4": "Cabe&#231;alho 4",

    // Style
    "Paragraph Style": "Estilo de par&#225;grafo",
    "Inline Style": "Estilo embutido",

    // Alignment
    "Align": "Alinhar",
    "Align Left": "Alinhar &#224; esquerda",
    "Align Center": "Centralizar",
    "Align Right": "Alinhar &#224; direita",
    "Align Justify": "Justificar",
    "None": "Nenhum",

    // Lists
    "Ordered List": "Lista ordenada",
    "Unordered List": "Lista n&#227;o ordenada",

    // Indent
    "Decrease Indent": "Diminuir recuo",
    "Increase Indent": "Aumentar recuo",

    // Links
    "Insert Link": "Inserir link",
    "Open in new tab": "Abrir em uma nova aba",
    "Open Link": "Abrir link",
    "Edit Link": "Editar link",
    "Unlink": "Remover link",
    "Choose Link": "Escolha o link",

    // Images
    "Insert Image": "Inserir imagem",
    "Upload Image": "Carregar imagem",
    "By URL": "Por um endere&#231;o URL",
    "Browse": "Procurar",
    "Drop image": "Arraste sua imagem aqui",
    "or click": "ou clique aqui",
    "Manage Images": "Gerenciar imagens",
    "Loading": "Carregando",
    "Deleting": "Excluindo",
    "Tags": "Etiquetas",
    "Are you sure? Image will be deleted.": "Voce tem certeza? A imagem sera apagada.",
    "Replace": "Substituir",
    "Uploading": "Carregando",
    "Loading image": "Carregando imagem",
    "Display": "Exibir",
    "Inline": "Em linha",
    "Break Text": "Texto de quebra",
    "Alternate Text": "Texto alternativo",
    "Change Size": "Alterar tamanho",
    "Width": "Largura",
    "Height": "Altura",
    "Something went wrong. Please try again.": "Algo deu errado. Por favor, tente novamente.",
    "Image Caption": "Legenda da imagem",
    "Advanced Edit": "Edi&#231;&#227;o avan&#231;ada",

    // Video
    "Insert Video": "Inserir v&#237;deo",
    "Embedded Code": "C&#243;digo embutido",
    "Paste in a video URL": "Colar um endere&#231;o de v&#237;deo",
    "Drop video": "Solte o v&#237;deo",
    "Your browser does not support HTML5 v&#237;deo.": "Seu navegador n&#227;o suporta v&#237;deo em HTML5.",
    "Upload Video": "Carregar v&#237;deo",

    // Tables
    "Insert Table": "Inserir tabela",
    "Table Header": "Cabe&#231;alho da tabela",
    "Remove Table": "Remover tabela",
    "Table Style": "Estilo de tabela",
    "Horizontal Align": "Alinhamento horizontal",
    "Row": "Linha",
    "Insert row above": "Inserir linha antes",
    "Insert row below": "Inserir linha depois",
    "Delete row": "Excluir linha",
    "Column": "Coluna",
    "Insert column before": "Inserir coluna antes",
    "Insert column after": "Inserir coluna depois",
    "Delete column": "Excluir coluna",
    "Cell": "C&#233;lula",
    "Merge cells": "Agrupar c&#233;lulas",
    "Horizontal split": "Divis&#227;o horizontal",
    "Vertical split": "Divis&#227;o vertical",
    "Cell Background": "Fundo da c&#233;lula",
    "Vertical Align": "Alinhamento vertical",
    "Top": "Topo",
    "Middle": "Meio",
    "Bottom": "Fundo",
    "Align Top": "Alinhar topo",
    "Align Middle": "Alinhar meio",
    "Align Bottom": "Alinhar fundo",
    "Cell Style": "Estilo de c&#233;lula",

    // Files
    "Upload File": "Carregar arquivo",
    "Drop file": "Arraste seu arquivo aqui",

    // Emoticons
    "Emoticons": "Emoticons",
    "Grinning face": "Rosto sorrindo",
    "Grinning face with smiling eyes": "Rosto sorrindo rosto com olhos sorridentes",
    "Face with tears of joy": "Rosto com l&#225;grimas de alegria",
    "Smiling face with open mouth": "Rosto sorrindo com a boca aberta",
    "Smiling face with open mouth and smiling eyes": "Rosto sorrindo com a boca aberta e olhos sorridentes",
    "Smiling face with open mouth and cold sweat": "Rosto sorrindo com a boca aberta e suor frio",
    "Smiling face with open mouth and tightly-closed eyes": "Rosto sorrindo com a boca aberta e os olhos bem fechados",
    "Smiling face with halo": "Rosto sorrindo com ar&#233;ola",
    "Smiling face with horns": "Rosto sorrindo com chifres",
    "Winking face": "Rosto piscando",
    "Smiling face with smiling eyes": "Rosto sorrindo com olhos sorridentes",
    "Face savoring delicious food": "Rosto saboreando uma deliciosa comida",
    "Relieved face": "Rosto aliviado",
    "Smiling face with heart-shaped eyes": "Rosto sorrindo com os olhos em forma de cora&#231;&#227;o",
    "Smiling face with sunglasses": "Rosto sorrindo com &#243;culos de sol",
    "Smirking face": "Rosto sorridente",
    "Neutral face": "Rosto neutro",
    "Expressionless face": "Rosto inexpressivo",
    "Unamused face": "Rosto sem express&#227;o",
    "Face with cold sweat": "Rosto com suor frio",
    "Pensive face": "Rosto pensativo",
    "Confused face": "Rosto confuso",
    "Confounded face": "Rosto at&#244;nito",
    "Kissing face": "Rosto beijando",
    "Face throwing a kiss": "Rosto jogando um beijo",
    "Kissing face with smiling eyes": "Rosto beijando com olhos sorridentes",
    "Kissing face with closed eyes": "Rosto beijando com os olhos fechados",
    "Face with stuck out tongue": "Rosto com a l&#237;ngua para fora",
    "Face with stuck out tongue and winking eye": "Rosto com a l&#237;ngua para fora e um olho piscando",
    "Face with stuck out tongue and tightly-closed eyes": "Rosto com a l&#237;ngua para fora e os olhos bem fechados",
    "Disappointed face": "Rosto decepcionado",
    "Worried face": "Rosto preocupado",
    "Angry face": "Rosto irritado",
    "Pouting face": "Rosto com beicinho",
    "Crying face": "Rosto chorando",
    "Persevering face": "Rosto perseverante",
    "Face with look of triumph": "Rosto com olhar de triunfo",
    "Disappointed but relieved face": "Rosto decepcionado mas aliviado",
    "Frowning face with open mouth": "Rosto franzido com a boca aberta",
    "Anguished face": "Rosto angustiado",
    "Fearful face": "Rosto com medo",
    "Weary face": "Rosto cansado",
    "Sleepy face": "Rosto com sono",
    "Tired face": "Rosto cansado",
    "Grimacing face": "Rosto fazendo careta",
    "Loudly crying face": "Rosto chorando alto",
    "Face with open mouth": "Rosto com a boca aberta",
    "Hushed face": "Rosto silencioso",
    "Face with open mouth and cold sweat": "Rosto com a boca aferta e suando frio",
    "Face screaming in fear": "Rosto gritando de medo",
    "Astonished face": "Rosto surpreso",
    "Flushed face": "Rosto envergonhado",
    "Sleeping face": "Rosto dormindo",
    "Dizzy face": "Rosto tonto",
    "Face without mouth": "Rosto sem boca",
    "Face with medical mask": "Rosto com m&#225;scara m&#233;dica",

    // Line breaker
    "Break": "Quebrar linha",

    // Math
    "Subscript": "Subscrito",
    "Superscript": "Sobrescrito",

    // Full screen
    "Fullscreen": "Tela cheia",

    // Horizontal line
    "Insert Horizontal Line": "Inserir linha horizontal",

    // Clear formatting
    "Clear Formatting": "Remover formata&#231;&#227;o",

    // Save
    "Save": "\u0053\u0061\u006c\u0076\u0065",

    // Undo, redo
    "Undo": "Desfazer",
    "Redo": "Refazer",

    // Select all
    "Select All": "Selecionar tudo",

    // Code view
    "Code View": "Exibir de c&#243;digo",

    // Quote
    "Quote": "Cita&#231;&#227;o",
    "Increase": "Aumentar",
    "Decrease": "Diminuir",

    // Quick Insert
    "Quick Insert": "Inser&#231;&#227;o r&#225;pida",

    // Spcial Characters
    "Special Characters": "Caracteres especiais",
    "Latin": "Latino",
    "Greek": "Grego",
    "Cyrillic": "Cir&#237;lico",
    "Punctuation": "Pontua&#231;&#227;o",
    "Currency": "Moeda",
    "Arrows": "Setas",
    "Math": "Matem&#225;tica",
    "Misc": "Misc",

    // Print.
    "Print": "Impress&#227;o",

    // Spell Checker.
    "Spell Checker": "Corretor ortogr&#225;fico",

    // Help
    "Help": "Ajuda",
    "Shortcuts": "Atalhos",
    "Inline Editor": "Editor em linha",
    "Show the editor": "Mostre o editor",
    "Common actions": "A&#231;&#245;es comuns",
    "Copy": "C&#243;pia de",
    "Cut": "Cortar",
    "Paste": "Colar",
    "Basic Formatting": "Formata&#231;&#227;o b&#225;sica",
    "Increase quote level": "Aumentar o n&#237;vel de cota&#231;&#227;o",
    "Decrease quote level": "Diminuir o n&#237;vel de cota&#231;&#227;o",
    "Image / Video": "Imagem / V&#237;deo",
    "Resize larger": "Redimensionar maior",
    "Resize smaller": "Redimensionar menor",
    "Table": "Tabela",
    "Select table cell": "Selecione a c&#233;lula da tabela",
    "Extend selection one cell": "Ampliar a sele&#231;&#227;o de uma c&#233;lula",
    "Extend selection one row": "Ampliar a sele&#231;&#227;o de uma linha",
    "Navigation": "Navega&#231;&#227;o",
    "Focus popup / toolbar": "Pop-up de foco / Barra de ferramentas",
    "Return focus to previous position": "Retornar o foco para a posi&#231;&#227;o anterior",

    // Embed.ly
    "Embed URL": "URL de inser&#231;&#227;o",
    "Paste in a URL to embed": "Colar um endere&#231;o URL para incorporar",

    // Word Paste.
    "The pasted content is coming from a Microsoft Word document. Do you want to keep the format or clean it up?": "O conte&#250;do colado vem de um documento Microsoft Word. Voc&#234; quer manter o formato ou limp&#225;-lo?",
    "Keep": "Manter",
    "Clean": "Limpar",
    "Word Paste Detected": "Colar do Word detectado"
  },
  direction: "ltr"
};

}));
