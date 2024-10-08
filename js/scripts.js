document.addEventListener("DOMContentLoaded", function () {
  const calendarElement = document.getElementById("calendar");
  const currentYearElement = document.getElementById("current-year");
  const currentMonthElement = document.getElementById("current-month");
  const today = new Date();
  let currentYear = today.getFullYear();
  let currentMonth = today.getMonth();

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
      "<th>Domingo</th><th>Segunda</th><th>Terça</th><th>Quarta</th><th>Quinta</th><th>Sexta</th><th>Sábado</th>";
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
              .padStart(2, "0")}/${String(day).padStart(2, "0")}.pdf" target="_blank" title="Abrir PD do dia ${day}/${month + 1}">
              <span class="fs-5 bi bi-file-earmark-pdf-fill pdf-icon"></span>${day}</a>
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

  function resetToToday() {
    currentYear = today.getFullYear();
    currentMonth = today.getMonth();
    renderCalendar(currentYear, currentMonth);
  }

  function goToDate(event) {
    event.preventDefault(); // Evita o envio do formulário
    const monthInput = document.getElementById("goto-month");
    const yearInput = document.getElementById("goto-year");
    const month = parseInt(monthInput.value, 10) - 1; // Ajusta o valor do mês (de 1-12 para 0-11)
    const year = parseInt(yearInput.value, 10);

    if (
      !isNaN(month) &&
      month >= 0 &&
      month <= 11 &&
      !isNaN(year) &&
      year >= 1900 &&
      year <= 2100
    ) {
      currentYear = year;
      currentMonth = month;
      renderCalendar(currentYear, currentMonth);
    } else {
      alert("Por favor, insira um mês e ano válidos.");
    }
  }

  document.getElementById("prev-year").addEventListener("click", function () {
    currentYear--;
    renderCalendar(currentYear, currentMonth);
  });

  document.getElementById("next-year").addEventListener("click", function () {
    currentYear++;
    renderCalendar(currentYear, currentMonth);
  });

  document.getElementById("prev-month").addEventListener("click", function () {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear--;
    } else {
      currentMonth--;
    }
    renderCalendar(currentYear, currentMonth);
  });

  document.getElementById("next-month").addEventListener("click", function () {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear++;
    } else {
      currentMonth++;
    }
    renderCalendar(currentYear, currentMonth);
  });

  document.getElementById("reset-date").addEventListener("click", resetToToday);

  document.getElementById("goto-date-form").addEventListener("submit", goToDate);

  // Adiciona o evento de clique para os dias com PDF
  calendarElement.addEventListener("click", function (event) {
    if (event.target.classList.contains("has-pdf")) {
      const date = event.target.dataset.date; // Supondo que date está no formato 'yyyy-mm-dd'
      const [year, month, day] = date.split('-');
      const filePath = `uploads/${year}/${month}/${day}.pdf`;
      window.open(filePath, "_blank");
    }
  });
  // Renderiza o mês atual
  renderCalendar(currentYear, currentMonth);
});

//Controle de confirmação do Upload
$(document).ready(function () {
  // Obtém a mensagem e o tipo da query string
  const urlParams = new URLSearchParams(window.location.search);
  const message = urlParams.get('message');
  const type = urlParams.get('type');

  if (message) {
    console.log("Message found:", message);
    console.log("Message type:", type);
    // Configura o conteúdo e a classe do alerta no modal
    $('#modal-content').addClass(`bg-${type}`);
    $('#modal-body').text(message).addClass('text-light');
    console.log("Modal should be shown now.");
    // Exibe o modal
    $('#messageModal').modal('show');
    // Recarrega a página e evita o modal ser carregado repetidamente
    const newUrl = window.location.pathname;
    window.history.replaceState(null, '', newUrl);
  } else {
    console.log("Nenhuma mensagem encontrada.");
  }
});

function exibirFraseDoDia() {
  fetch('get_frases.php')
  .then(response => response.json())
  .then(data => {
      const fraseDoDiaElement = document.getElementById('frase-do-dia');
      if (fraseDoDiaElement && data.frase) {
          fraseDoDiaElement.textContent = data.frase;
      } else {
          console.error('Frase do dia não encontrada no JSON.');
      }
  })
  .catch(error => {
      console.error('Erro ao obter a frase do dia:', error);
  });
}
// Chama a função quando a página carrega
document.addEventListener('DOMContentLoaded', exibirFraseDoDia);

function updateClock() {
  const now = new Date();
  const hours = String(now.getHours()).padStart(2, '0');
  const minutes = String(now.getMinutes()).padStart(2, '0');
  const seconds = String(now.getSeconds()).padStart(2, '0');

  const timeString = `${hours}:${minutes}:${seconds}`;
  
  document.getElementById('clock').textContent = timeString;
}

// Atualiza o relógio a cada segundo
setInterval(updateClock, 1000);

// Chama a função ao carregar a página para não esperar 1 segundo
updateClock();


