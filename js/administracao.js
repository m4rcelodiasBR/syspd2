//Listando PDFs do mês
function renderPdfList(year, month) {
  const fileListElement = document.getElementById("file-list");
  fileListElement.innerHTML = "Carregando PDFs..."; // Mensagem enquanto carrega

  fetch(
    `list_pdfs.php?year=${year}&month=${String(month + 1).padStart(2, "0")}`
  )
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        fileListElement.innerHTML = ""; // Limpa a mensagem de carregamento
        if (Array.isArray(data.files)) {
          data.files.forEach((file) => {
            const fileItem = document.createElement("div");
            fileItem.classList.add(
              "pdf-item",
              "d-flex",
              "justify-content-between",
              "align-items-center",
              "mb-2"
            );

            // Ícone PDF
            const icon = document.createElement("i");
            icon.classList.add("fs-5", "bi", "bi-file-earmark-pdf-fill", "pdf-icon");

            // Nome do arquivo com link
            const link = document.createElement("a");
            link.href = `uploads/${year}/${String(month + 1).padStart(2, "0")}/${file}`;
            link.target = "_blank";
            link.textContent = file.replace(/\.pdf$/, "");
            link.classList.add("pdf-link");

            // Botão de exclusão
            const deleteButton = document.createElement("button");
            deleteButton.classList.add(
              "fs-5",
              "btn",
              "btn-danger",
              "btn-sm",
              "delete-btn",
              "bi",
              "bi-trash"
            );
            // Evento de click para o modal de confirmação
            deleteButton.addEventListener("click", () => {
              // Armazena os dados do arquivo no botão de confirmação do modal
              const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
              confirmDeleteBtn.setAttribute("data-year", year);
              confirmDeleteBtn.setAttribute("data-month", (month + 1));
              confirmDeleteBtn.setAttribute("data-file", file);

              // Abre o modal de confirmação
              const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
              deleteModal.show();
            });

            // Adiciona o ícone, link e botão ao item
            fileItem.appendChild(icon);
            fileItem.appendChild(link);
            fileItem.appendChild(deleteButton);

            // Adiciona o item à lista
            fileListElement.appendChild(fileItem);
          });
        } else {
          fileListElement.innerHTML = "Formato de resposta inesperado.";
        }
      } else {
        fileListElement.innerHTML = "Nenhum PDF encontrado.";
      }
    })
    .catch((error) => {
      console.error("Erro ao carregar PDFs:", error);
      fileListElement.innerHTML = "Erro ao carregar PDFs.";
    });
}

//Confirmando exclusão de PDFs
const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
if (confirmDeleteBtn) {
  confirmDeleteBtn.addEventListener("click", function () {
    const year = this.getAttribute("data-year");
    const month = this.getAttribute("data-month");
    const file = this.getAttribute("data-file");

    deletePdf(year, month, file);

    // Fecha o modal após a confirmação
    const deleteModal = bootstrap.Modal.getInstance(document.getElementById("deleteModal"));
    deleteModal.hide();
  });
}

// Controle para excluir PDF
function deletePdf(year, month, file) {
  fetch(`delete_pdf.php?year=${year}&month=${String(month).padStart(2, '0')}&file=${file}`, {
    method: 'GET',
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        document.getElementById('deleteMessage').textContent = 'Arquivo excluído com sucesso!';
        $('#confirmDeleteModal').modal('show');
        renderPdfList(year, month - 1); // Atualiza a lista após exclusão
      } else {
        document.getElementById('deleteMessage').textContent = 'Erro ao excluir o arquivo.';
        $('#confirmDeleteModal').modal('show');
      }
    })
    .catch(error => {
      console.error('Erro ao excluir PDF:', error);
      document.getElementById('deleteMessage').textContent = 'Erro ao excluir o arquivo.';
      $('#confirmDeleteModal').modal('show');
    });
}

// Controle de logout
document.getElementById("logoutSistema").addEventListener("click", function () {
  console.log('Chamando logout');
  fetch('logout.php', {
    method: 'POST'
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        window.location.href = '/syspd2';
      } else {
        alert('Erro ao efetuar logout');
      }
    })
    .catch(error => {
      console.error('Erro ao efetuar logout:', error);
    });
});