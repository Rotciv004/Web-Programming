let currentPage = 1;

function loadLinks(page) {
  const cat = document.getElementById('selectCategory').value;
  const xhr = new XMLHttpRequest();
  xhr.open('GET', `get_links.php?page=${page}&category=${encodeURIComponent(cat)}`, true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      displayLinks(xhr.responseXML);
    }
  };
  xhr.send();
}

function displayLinks(xml) {
  const container = document.getElementById('linksContainer');
  container.innerHTML = '';
  const pageNode = xml.getElementsByTagName('page')[0];
  currentPage = parseInt(pageNode.getAttribute('current'));
  const total = parseInt(pageNode.getAttribute('total'));
  document.getElementById('pageInfo').textContent = `${currentPage} / ${total}`;
  document.getElementById('prevBtn').disabled = (currentPage <= 1);
  document.getElementById('nextBtn').disabled = (currentPage >= total);

  const links = xml.getElementsByTagName('link');
  for (let i = 0; i < links.length; i++) {
    const url  = links[i].getElementsByTagName('url')[0].textContent;
    const desc = links[i].getElementsByTagName('desc')[0].textContent;
    const cat  = links[i].getElementsByTagName('cat')[0].textContent;
    const id   = links[i].getElementsByTagName('id')[0].textContent;

    const div = document.createElement('div');
    div.innerHTML = `<a href="${url}" target="_blank">${desc}</a>
      <span>[${cat}]</span>
      <a href="delete_link.php?id=${id}" onclick="return confirm('Confirm?')">🗑</a>`;
    container.appendChild(div);
  }
}

function prevPage() { if (currentPage > 1) loadLinks(currentPage - 1); }
function nextPage() { loadLinks(currentPage + 1); }

window.onload = () => loadLinks(1);
