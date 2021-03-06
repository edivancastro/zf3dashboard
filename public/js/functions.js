var screenWidth, screenHeight, dialogWidth;

screenWidth = window.screen.width;
screenHeight = window.screen.height;

var minWidth = 600;

if ( screenWidth < minWidth ) {
   dialogWidth = screenWidth * .95;
   dialogHeight = screenHeight - 220;
} else {
   dialogWidth = minWidth;
   dialogHeight = screenHeight - 220;
} 


var updateMsgBox = function(dados, url,action, table){
	$(table).find('tbody, tfoot > tr > td').html('');
	
	//popula a tabela
	if(dados.mensagens==''){
		$(table).find('tbody').append('<tr class="empty"><td colspan="3">Nenhuma mensagem</td></tr>');
	}else{


		$(dados.mensagens).each(function(key,msg){

			var data = moment(msg.mensagem.dataenvio.date);


			if(data.format('DD/MM/YYYY')==moment().format('DD/MM/YYYY')){
				data = data.format('HH:mm');
			}else{
				data = data.format('DD/MM/YYYY');
			}

			var classe = '';

			if(msg.dataleitura == null && dados.box == 1){
				classe = 'class="new"';
			}

			var nome = msg.mensagem.remetente.nome;

			if(nome != null && nome.split(' ').length > 1){
				nome = nome.split(' ').shift()+" "+nome.split(' ').pop();
			}

			var row = '<tr '+classe+'>';
			row += '<td><a href="'+url+'/read/'+msg.mensagem.id+'">'+(msg.mensagem.assunto==null?"":msg.mensagem.assunto)+'</a></td>';
			row += '<td class="hidden-xs"><a href="'+url+'/read/'+msg.mensagem.id+'">'+( nome==null?'':nome )+'</a></td>';
			row += '<td>'+data+'</td>';
			row += '</tr>';

			$(table).find('tbody').append(row);
		});	
	}

	//paginator

	if(dados.query==null){
		query = '';
	}else{
		query='&query='+dados.query;
	}

	query +='&box='+dados.box;

	var paginator = dados.paginator;
	if(paginator.pageCount){
		var html = '<nav><ul class="pagination">';

		//Previous page link
		if(paginator.hasOwnProperty('previous')){
			html += '<li>';
			html += '<a href="'+url+'/'+action+'?page='+paginator.previous+query+'" aria-label="Previous">';
			html += '<span aria-hidden="true">&laquo;</span>';
			html += '</a></li>';
		}else{
			html += '<li><span aria-hidden="true">&laquo;</span></li>';
		}
		

		for(key in paginator.pagesInRange){
			var page = paginator.pagesInRange[key];

			if(page != paginator.current){
				html += '<li><a href="'+url+'/'+action+'?page='+page+query+'">'+page+'</a></li>';
			}else{
				html += '<li><span aria-hidden="true"><b>'+page+'</b></span></li>';
			}
		};

		//Next page link
		if(paginator.hasOwnProperty('next')){
			html += '<li><a href="'+url+'/'+action+'?page='+paginator.next+query+'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		}else{
			html += '<li><span aria-hidden="true">&raquo;</span></li>';
		}

		html += '</ul></nav>';

		$(table).find('tfoot > tr > td').html(html);
	}

}


var updateUsrList = function(dados, url, action, table){
	$(table).find('tbody, tfoot > tr > td').html('');
	
	//popula a tabela
	if(dados.usuarios==''){
		$(table).find('tbody').append('<tr class="empty"><td colspan="3">Nenhuma mensagem</td></tr>');
	}else{


		$(dados.usuarios).each(function(key,usuario){

			var nome = usuario.nome;

			var row = '<tr>';
			row += '<td><input type="hidden" name="idusuario" value="'+usuario.id+'" />'+usuario.id+'</td>';
			row += '<td>'+nome+'</a></td>';
			row += '<td>'+usuario.role.descricao+'</td>';
			row += '</tr>';

			$(table).find('tbody').append(row);
		});	
	}

	//paginator

	if(dados.busca==null){
		query = '';
	}else{
		query='&busca='+dados.busca;
	}


	var paginator = dados.paginator;
	if(paginator.pageCount){
		var html = '<nav><ul class="pagination">';

		//Previous page link
		if(paginator.hasOwnProperty('previous')){
			html += '<li>';
			html += '<a href="'+url+'/'+action+'?page='+paginator.previous+query+'" aria-label="Previous">';
			html += '<span aria-hidden="true">&laquo;</span>';
			html += '</a></li>';
		}else{
			html += '<li><span aria-hidden="true">&laquo;</span></li>';
		}
		

		for(key in paginator.pagesInRange){
			var page = paginator.pagesInRange[key];

			if(page != paginator.current){
				html += '<li><a href="'+url+'/'+action+'?page='+page+query+'">'+page+'</a></li>';
			}else{
				html += '<li><span aria-hidden="true"><b>'+page+'</b></span></li>';
			}
		};

		//Next page link
		if(paginator.hasOwnProperty('next')){
			html += '<li><a href="'+url+'/'+action+'?page='+paginator.next+query+'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
		}else{
			html += '<li><span aria-hidden="true">&raquo;</span></li>';
		}

		html += '</ul></nav>';

		$(table).find('tfoot > tr > td').html(html);
	}

}


