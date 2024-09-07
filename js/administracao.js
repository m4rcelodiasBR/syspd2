function renderCalendar(year, month) {
  const firstDay = new Date(year, month, 1);
  const lastDay = new Date(year, month + 1, 0);
  const daysInMonth = lastDay.getDate();
  const startingDay = firstDay.getDay();
  const endingDay = lastDay.getDay();

  // Atualiza o texto do mês e ano
  const monthNames = [
    "Janeiro",
    "Fevereiro",
    "Março",
    "Abril",
    "Maio",
    "Junho",
    "Julho",
    "Agosto",
    "Setembro",
    "Outubro",
    "Novembro",
    "Dezembro",
  ];
  currentYearElement.textContent = year;
  currentMonthElement.textContent = monthNames[month];

  let html = '<table class="table table-bordered">';
  html += "<thead><tr>";
  html +=
    "<th>Dom</th><th>Seg</th><th>Ter</th><th>Qua</th><th>Qui</th><th>Sex</th><th>Sáb</th>";
  html += "</tr></thead><tbody><tr>";

  // Preenche as células vazias no início com os dias do mês anterior
  const prevMonthLastDay = new Date(year, month, 0).getDate();
  for (let i = 0; i < startingDay; i++) {
    html += `<td class="other-month">${prevMonthLastDay - startingDay + i + 1
      }</td>`;
  }

  // Função para verificar se o dia tem PDF
  function hasPdf(year, month, day) {
    const dateStr = `${year}-${String(month).padStart(2, "0")}-${String(day).padStart(2, "0")}`;
    return fetch(`check_pdf.php?date=${encodeURIComponent(dateStr)}`)
      .then((response) => response.text())
      .then((data) => data.includes("Ver PDF"));
  }

  // Armazena as promessas de verificação de PDF para cada dia
  const pdfChecks = [];

  for (let day = 1; day <= daysInMonth; day++) {
    const isToday =
      year === today.getFullYear() &&
      month === today.getMonth() &&
      day === today.getDate();
    let className = "day";
    if (isToday) {
      className += " today";
    }

    const dateStr = `${year}-${String(month + 1).padStart(2, "0")}-${String(
      day
    ).padStart(2, "0")}`;
    html += `<td class="${className}" data-date="${dateStr}">${day}</td>`;

    // Adiciona a promessa de verificação de PDF para este dia
    pdfChecks.push(
      hasPdf(year, month + 1, day).then((hasPdf) => {
        const cell = calendarElement.querySelector(`td[data-date="${dateStr}"]`);
        if (hasPdf) {
          cell.classList.add("has-pdf");
          cell.innerHTML = `<a href="uploads/${year}/${String(month + 1)
            .padStart(2, "0")}/${String(day).padStart(2, "0")}.pdf" target="_blank">
            <span class="bi bi-file-earmark-pdf-fill pdf-icon"></span>${day}</a>
            `;
        } else {
          cell.innerHTML = day; // Mantém o dia se não houver PDF
        }
      })
    );

    // Fecha a linha a cada 7 dias
    if ((startingDay + day) % 7 === 0) {
      html += "</tr><tr>";
    }
  }

  // Preenche as células vazias no final com os dias do próximo mês
  let nextMonthDay = 1;
  for (let i = endingDay + 1; i <= 6; i++) {
    html += `<td class="other-month">${nextMonthDay++}</td>`;
  }

  html += "</tr></tbody></table>";
  calendarElement.innerHTML = html;

  renderPdfList(year, month);
}

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
            icon.classList.add("bi", "bi-file-earmark-pdf-fill", "pdf-icon");

            // Nome do arquivo com link
            const link = document.createElement("a");
            link.href = `uploads/${year}/${String(month + 1).padStart(2, "0")}/${file}`;
            link.target = "_blank";
            link.textContent = file.replace(/\.pdf$/, "");
            link.classList.add("pdf-link");

            // Botão de exclusão
            const deleteButton = document.createElement("button");
            deleteButton.classList.add(
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