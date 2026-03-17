(function(){
  function escapeHtml(str){
    return String(str).replace(/[&<>"']/g, function(m){
      return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m];
    });
  }
  function nl2br(str){
    return escapeHtml(str).replace(/\n/g,'<br>');
  }
  function getWidget(){
    return document.querySelector('.chat-aibox');
  }
  function addMessage(type, text){
    var box = document.querySelector('.chat-aibox-messages');
    if(!box) return;
    var item = document.createElement('div');
    item.className = 'chat-msg ' + type;
    item.innerHTML = '<div class="bubble">' + nl2br(text) + '</div>';
    box.appendChild(item);
    box.scrollTop = box.scrollHeight;
  }
  function sendMessage(text){
    var widget = getWidget();
    if(!widget || !text) return;
    addMessage('user', text);
    var endpoint = widget.getAttribute('data-endpoint') || 'chat_ai_box.php';
    var formData = new FormData();
    formData.append('message', text);
    fetch(endpoint, {method:'POST', body: formData})
      .then(function(r){ return r.json(); })
      .then(function(data){ addMessage('bot', data.reply || 'Mình chưa phản hồi được lúc này.'); })
      .catch(function(){ addMessage('bot', 'Không thể kết nối ChatAiBox. Vui lòng thử lại sau.'); });
  }

  document.addEventListener('click', function(e){
    var launcher = e.target.closest('.chat-launch-btn');
    if(launcher){
      e.preventDefault();
      var widget = getWidget();
      if(widget){ widget.classList.add('open'); }
      return;
    }
    var toggle = e.target.closest('.chat-aibox-toggle');
    if(toggle){
      var widget = getWidget();
      if(widget){ widget.classList.toggle('open'); }
      return;
    }
    var quick = e.target.closest('.chat-aibox-quick button');
    if(quick){
      sendMessage(quick.getAttribute('data-text') || quick.textContent.trim());
    }
  });

  document.addEventListener('submit', function(e){
    if(e.target.matches('.chat-aibox-form')){
      e.preventDefault();
      var input = e.target.querySelector('input[name="message"]');
      if(!input) return;
      var text = input.value.trim();
      if(!text) return;
      input.value = '';
      sendMessage(text);
    }
  });
})();
