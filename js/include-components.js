// include-components.js — loads HTML partials denoted by data-include attributes
(async function(){
  async function loadInclude(el){
    const url = el.getAttribute('data-include');
    if(!url) return;
    try{
      const res = await fetch(url);
      if(!res.ok) throw new Error('Nie można załadować: '+url);
      const html = await res.text();
      el.innerHTML = html;
    }catch(e){ console.error(e); }
  }
  document.addEventListener('DOMContentLoaded', ()=>{
    document.querySelectorAll('[data-include]').forEach(el=>loadInclude(el));
  });
})();
