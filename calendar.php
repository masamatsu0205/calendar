<!DOCTYPE html>
<html>


<head>
    <meta charset="UTF-8">
    <title>カレンダー</title>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
    <style>
        /* オーバーレイ（暗い背景） */
        .overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* モーダル共通スタイル */
        .modal {
            display: none;
            position: fixed;
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            background: #3b0b0b;
            border: 2px solid #00D9FF;
            border-radius: 12px;
            padding: 20px;
            z-index: 1000;
        }

        /* タイトル */
        h1 {
            text-align: center;
            color:#00D9FF;
        }

        #calendarHeader {
            display: flex;           /* 横並びにする */
            justify-content: space-between; /* 左・中央・右に均等配置 */
            align-items: center;     /* 縦方向を中央揃え */
            width: 80%;              /* カレンダーと同じ幅 */
            margin: 10px auto;       /* カレンダーと同じく中央寄せ */
        }

        #calendarTitle {
            font-size: 36px;
            font-weight: 900;
            color:#00D9FF;
            letter-spacing: 2px;
        }

        #monthNav {
            text-align: center;
        }

        /* カレンダーのテーブル */
        #calendar {
            width: 70%;
            margin: 4px auto;
            border: 2px solid #3b0b0b;
            border-spacing: 0;
            background: white;
            border-radius: 10px;
            overflow: hidden;

        }

        #calendar tr:first-child td {
            font-size: 18px;
            font-weight: 700;
            color: #00D9FF;
            background: #7b7256;
            text-align: center;
            vertical-align: middle;
            padding: 10px 0;
        }


        /* 各セル */
        #calendar td {
            padding: 0px;
            text-align: center;
            height: 80px;
            width: 14%;
            vertical-align: top;
            border: 2px solid #3b0b0b;
            font-weight: 500;
        }

        /* タイムラインモーダル */
        #viewModal {
            width: 600px;
            height: 90vh;
            overflow-y: auto;
        }

        /*カラー変更*/
        #viewModalTitle {
            color: #00D9FF;
        }
        #modal h3 {
            color: #00D9FF; 
        }
        #modal label {
            color: #00D9FF; 
        }


        /* タイムラインの各行 */
        .timeline-row {
            display: flex;
            align-items: flex-start;
            border-top: 1px solid#7b7256;
            min-height: 5px;
            padding: 1px 0;
        }

        /* 時刻ラベル */
        .timeline-time {
            width: 50px;
            font-size: 12px;
            color: #00D9FF;
            flex-shrink: 0;
        }

        /* 予定の中身 */
        .timeline-event {
            background: lightblue;
            border-radius: 4px;
            padding: 2px 6px;
            margin: 2px 4px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* 削除ボタン（×） */
        .timeline-event button {
            background: none;
            border: none;
            color: red;
            cursor: pointer;
            font-size: 14px;
            padding: 0;
        }

        /*色選択*/
        .colorOption {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            font-size: 10px;
            color: white;
            margin: 2px;
            border: 2px solid transparent;
            vertical-align: middle;
        }
        .colorOption.selected {
            border: 2px solid black;
        }

        /*フォント*/
        body {
            font-family: 'M PLUS Rounded 1c', sans-serif;
            font-weight: 400;
    
            /*
            background-color: #3b0b0b;
            */
            background-image: url("97744961.jpg");
            background-position: 10% 30%; 
            background-size: 110%;   
            background-repeat: no-repeat; /* 繰り返さない */

        }
        button, input, select, textarea {
            font-family: inherit !important;
        }

        
        /*ボタンサイズ*/
        button {
            font-family: inherit;
            padding: 8px 14px;
            font-size: 20px;
            border-radius: 8px;
            border: 3px solid #3b0b0b;
            background: #7b7256;
            color: #00D9FF;
            transition: 0.2s;
        }

        button:hover {
            background: #ada07a;
            transform: translateY(-1px);
        }

        /*背景*/
        .overlay {
            background: rgba(0, 0, 0, 0.4);
        }

    </style>
</head>
<body>

    <h1 id="title">カレンダー</h1>

    <!-- オーバーレイ -->
    <div id="overlay" class="overlay" onclick="closeModal()"></div>

    <!-- 予定追加モーダル -->
    <div id="modal" class="modal">
        <h3>予定追加</h3>
        <label>年: <input type="number" id="inputYear"></label><br><br>
        <label>月: <input type="number" id="inputMonth" min="1" max="12"></label><br><br>
        <label>日: <input type="number" id="inputDate"  min="1" max="31"></label><br><br>
        <label>開始: <input type="time" id="inputStartTime"></label><br><br>
        <label>終了: <input type="time" id="inputEndTime"></label><br><br>
        <label>予定: <input type="text" id="inputEvent"></label><br><br>
        <label>色: 
            <button type="button" id="colorToggleBtn" onclick="toggleColorPicker()">🎨 色を選ぶ</button>
        </label>
        <div id="colorPicker" style="display:none;">
            <span class="colorOption" data-color="#e74c3c" style="background:#e74c3c;">赤</span>
            <span class="colorOption" data-color="#e67e22" style="background:#e67e22;">オレンジ</span>
            <span class="colorOption" data-color="#2ecc71" style="background:#2ecc71;">緑</span>
            <span class="colorOption" data-color="#1abc9c" style="background:#1abc9c;">ミント</span>
            <span class="colorOption" data-color="#3498db" style="background:#3498db;">青</span>
            <span class="colorOption" data-color="#9b59b6" style="background:#9b59b6;">紫</span>
            <span class="colorOption" data-color="#e91e63" style="background:#e91e63;">ピンク</span>
            <span class="colorOption" data-color="#795548" style="background:#795548;">茶</span>
            <span class="colorOption" data-color="#607d8b" style="background:#607d8b;">グレー</span>
        </div>
        <input type="hidden" id="inputColor" value="#3498db">
        <button onclick="saveEvent()">追加</button>
        <button onclick="closeModal()">キャンセル</button>
    </div>

    <!-- タイムラインモーダル -->
    <div id="viewModal" class="modal">
        <h3 id="viewModalTitle"></h3>
        <div id="timeline"></div>
        <br>
        <button onclick="closeViewModal()">閉じる</button>
    </div>

    <!-- ボタン類 -->
    <div id="calendarHeader">
        <div id="monthNav">
            <button onclick="prevMonth()">＜＜</button>
            <button onclick="goToday()">今月へ</button>
            <button onclick="nextMonth()">＞＞</button>
        </div>
        <div id="calendarTitle"></div>
        <div>
            <button onclick="openModal()">予定追加</button>
        </div>
    </div>
    <table border="1" id="calendar"></table>

    <script>
        // ==============================
        // 変数
        // ==============================

        let events       = {};
        let currentYear  = new Date().getFullYear();
        let currentMonth = new Date().getMonth();
        let editingKey   = "";
        let editingId    = -1;

        const today      = new Date();
        const todayYear  = today.getFullYear();
        const todayMonth = today.getMonth();
        const todayDate  = today.getDate();
        const days       = ["日", "月", "火", "水", "木", "金", "土"];
        let holidays     = {};


        // ==============================
        // 初期化
        // ==============================

        window.onload = async function () {
            await fetchHolidays();
            await loadEvents();
        };


        // ==============================
        // 祝日データ取得
        // ==============================

        async function fetchHolidays() {
            const res  = await fetch("https://holidays-jp.github.io/api/v1/date.json");
            const data = await res.json();

            for (let dateStr in data) {
                let d   = new Date(dateStr);
                let key =
                    d.getFullYear() + "-" +
                    String(d.getMonth() + 1).padStart(2, "0") + "-" +
                    String(d.getDate()).padStart(2, "0");
                holidays[key] = data[dateStr];
            }
        }


        // ==============================
        // DBからデータ取得
        // ==============================

        async function loadEvents() {
            const res  = await fetch("get.php");
            const data = await res.json();

            events = {};

            data.forEach(ev => {
                let key = ev.date;
                if (!events[key]) { events[key] = []; }
                events[key].push({
                    id:         ev.id,
                    start_time: ev.start_time,  // "09:00:00" 形式で返ってくる
                    end_time:   ev.end_time,
                    text:       ev.text,
                    color:      ev.color
                });
            });

            renderCalendar();
        }


        // ==============================
        // 時刻を "HH:MM" 形式に整形
        // ==============================

        function formatTime(timeStr) {
            // MySQLのTIME型は "09:00:00" で返ってくるので "09:00" に切り詰める
            return timeStr.slice(0, 5);
        }


        // ==============================
        // カレンダー描画
        // ==============================

        function renderCalendar() {
            updateUI();

            const calendar     = document.getElementById("calendar");
            calendar.innerHTML = "";

            const firstDay     = new Date(currentYear, currentMonth, 1).getDay();
            const lastDate     = new Date(currentYear, currentMonth + 1, 0).getDate();
            const prevLastDate = new Date(currentYear, currentMonth, 0).getDate();

            document.getElementById("title").textContent =
                currentYear + "年" + (currentMonth + 1) + "月";

            let html = "<tr>";

            for (let d of days) {
                html += "<td>" + d + "</td>";
            }
            html += "</tr><tr>";

            for (let i = 0; i < firstDay; i++) {
                html += "<td style='color:lightgray'>" + (prevLastDate - firstDay + i + 1) + "</td>";
            }

            let count = firstDay;

            for (let d = 1; d <= lastDate; d++) {

                let dayOfWeek = (d + firstDay - 1) % 7;
                let key =
                    currentYear + "-" +
                    String(currentMonth + 1).padStart(2, "0") + "-" +
                    String(d).padStart(2, "0");

                let color      = "";
                let todayStyle = "";

                if      (dayOfWeek === 0) { color = "red";  }
                else if (dayOfWeek === 6) { color = "blue"; }

                if (holidays[key]) { color = "red"; }

                let isToday = (
                    currentYear  === todayYear  &&
                    currentMonth === todayMonth &&
                    d            === todayDate
                );
                if (isToday) {
                    color      = "green";
                    todayStyle = "font-size:25px; font-weight:bold;";
                }

                // 予定のラベルを生成（先頭4文字）
                let dots = "";
                if (events[key]) {
                    for (let ev of events[key]) {
                        dots +=
                            "<span style='background:" + ev.color +
                            "; color:white; font-size:10px; padding:2px 4px; margin:1px; border-radius:4px; display:inline-block;'>" +
                            ev.text.slice(0, 4) +
                            "</span>";
                    }
                }

                html +=
                    "<td style='color:" + color + "; " + todayStyle + "' onclick='openTimeline(\"" + key + "\")'>" +
                    d + "<br>" + dots +
                    "</td>";

                count++;
                if (count % 7 === 0) { html += "</tr><tr>"; }
            }

            let nextDate = 1;
            while (count % 7 !== 0) {
                html += "<td style='color:lightgray'>" + nextDate + "</td>";
                nextDate++;
                count++;
            }

            html += "</tr>";
            calendar.innerHTML = html;
        }


        // ==============================
        // タイムライン表示
        // ==============================

        function openTimeline(key) {

            let titleText = key;
            if (holidays[key]) { titleText += " 🎌 " + holidays[key]; }
            document.getElementById("viewModalTitle").textContent = titleText;

            let html = "";

            for (let h = 0; h < 24; h++) {

                html += "<div class='timeline-row'>";
                html += "<div class='timeline-time'>" + h + ":00</div>";
                html += "<div class='timeline-events'>";

                if (events[key]) {
                    for (let idx = 0; idx < events[key].length; idx++) {
                        let ev         = events[key][idx];
                        let startHour  = parseInt(ev.start_time.split(":")[0]);
                        let endHour    = parseInt(ev.end_time.split(":")[0]);
                        let startMin   = parseInt(ev.start_time.split(":")[1]);
                        let endMin     = parseInt(ev.end_time.split(":")[1]);

                        // 開始時刻の行に予定を表示
                        if (startHour === h) {
                            let startStr = formatTime(ev.start_time);
                            let endStr   = formatTime(ev.end_time);

                            html +=
                                "<div class='timeline-event' style='background:" + ev.color + "; color:white; cursor:pointer;' " +
                                "onclick='editEvent(\"" + key + "\"," + idx + ")'>" +
                                // 時刻を "09:00-10:30" 形式で表示して改行後に予定内容
                                "<div>" +
                                "<div style='font-size:11px;'>" + startStr + " - " + endStr + "</div>" +
                                "<div>" + ev.text + "</div>" +
                                "</div>" +
                                "<button onclick='event.stopPropagation(); deleteEvent(\"" + key + "\"," + idx + ")'>×</button>" +
                                "</div>";
                        }

                        // 開始〜終了の間の行に色帯を表示
                        if (h > startHour && (h < endHour || (h === endHour && endMin > 0))) {
                            html +=
                                "<div style='background:" + ev.color +
                                "; opacity:0.4; height:100%; min-height:20px; width:8px; border-radius:2px; margin:1px 4px;'></div>";
                        }
                    }
                }

                html += "</div></div>";
            }

            document.getElementById("timeline").innerHTML = html;
            document.getElementById("viewModal").style.display = "block";
            document.getElementById("overlay").style.display  = "block";

            // 開始時刻付近にスクロール
            const currentHour = new Date().getHours();
            const rows        = document.querySelectorAll(".timeline-row");
            if (rows[currentHour]) {
                rows[currentHour].scrollIntoView({ block: "center" });
            }
        }

        function closeViewModal() {
            document.getElementById("viewModal").style.display = "none";
            document.getElementById("overlay").style.display  = "none";
        }


        // ==============================
        // 予定削除（DB連携）
        // ==============================

        function deleteEvent(key, idx) {
            const id = events[key][idx].id;

            fetch("delete.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + id
            }).then(() => {
                loadEvents().then(() => openTimeline(key));
            });
        }


        // ==============================
        // 予定追加モーダル
        // ==============================

        function openModal() {
            const now = new Date();

            document.getElementById("inputYear").value      = currentYear;
            document.getElementById("inputMonth").value     = currentMonth + 1;
            document.getElementById("inputDate").value      = now.getDate();
            document.getElementById("inputStartTime").value =
                String(now.getHours()).padStart(2, "0") + ":" +
                String(now.getMinutes()).padStart(2, "0");
            document.getElementById("inputEndTime").value   =
                String(now.getHours() + 1).padStart(2, "0") + ":" +
                String(now.getMinutes()).padStart(2, "00");  // 開始の1時間後をデフォルトに
            document.getElementById("inputEvent").value     = "";

            // 色選択をリセット
            document.getElementById("colorPicker").style.display  = "none";
            document.getElementById("colorToggleBtn").textContent = "🎨 色を選ぶ";
            document.querySelectorAll(".colorOption").forEach(e => e.classList.remove("selected"));
            document.getElementById("inputColor").value = "#3498db";

            // 編集状態をリセット
            editingKey = "";
            editingId  = -1;

            document.getElementById("modal").style.display   = "block";
            document.getElementById("overlay").style.display = "block";
        }

        function closeModal() {
            document.getElementById("modal").style.display   = "none";
            document.getElementById("overlay").style.display = "none";
        }


        // ==============================
        // 予定保存（新規 or 編集）
        // ==============================

        function saveEvent() {
            const year      = document.getElementById("inputYear").value;
            const month     = String(document.getElementById("inputMonth").value).padStart(2, "0");
            const date      = String(document.getElementById("inputDate").value).padStart(2, "00");
            const startTime = document.getElementById("inputStartTime").value;
            const endTime   = document.getElementById("inputEndTime").value;
            const text      = document.getElementById("inputEvent").value;
            const color     = document.getElementById("inputColor").value;

            if (!year || !month || !date || !startTime || !endTime || !text) {
                alert("全て入力してください");
                return;
            }

            if (startTime >= endTime) {
                alert("終了時刻は開始時刻より後にしてください");
                return;
            }

            const dateStr = year + "-" + month + "-" + date;

            const body =
                "date="       + dateStr                     +
                "&start_time="+ startTime                   +
                "&end_time="  + endTime                     +
                "&text="      + encodeURIComponent(text)    +
                "&color="     + encodeURIComponent(color);

            const url = editingId !== -1 ? "update.php" : "save.php";
            const fullBody = editingId !== -1 ? body + "&id=" + editingId : body;

            fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: fullBody
            }).then(() => {
                closeModal();
                loadEvents();
            });
        }


        // ==============================
        // 予定編集
        // ==============================

        function editEvent(key, idx) {
            const ev    = events[key][idx];
            const parts = key.split("-");

            document.getElementById("inputYear").value      = parts[0];
            document.getElementById("inputMonth").value     = Number(parts[1]);
            document.getElementById("inputDate").value      = Number(parts[2]);
            document.getElementById("inputStartTime").value = formatTime(ev.start_time);
            document.getElementById("inputEndTime").value   = formatTime(ev.end_time);
            document.getElementById("inputEvent").value     = ev.text;
            document.getElementById("inputColor").value     = ev.color;

            // 色ボタンの表示を更新
            document.getElementById("colorPicker").style.display = "none";
            const matchingOption = document.querySelector(".colorOption[data-color='" + ev.color + "']");
            if (matchingOption) {
                document.querySelectorAll(".colorOption").forEach(e => e.classList.remove("selected"));
                matchingOption.classList.add("selected");
                document.getElementById("colorToggleBtn").textContent = "🎨 " + matchingOption.textContent;
            }

            editingKey = key;
            editingId  = ev.id;

            closeViewModal();
            document.getElementById("modal").style.display   = "block";
            document.getElementById("overlay").style.display = "block";
        }


        // ==============================
        // 色ピッカー
        // ==============================

        function toggleColorPicker() {
            const picker = document.getElementById("colorPicker");
            picker.style.display = picker.style.display === "none" ? "block" : "none";
        }

        document.querySelectorAll(".colorOption").forEach(el => {
            el.addEventListener("click", function () {
                document.querySelectorAll(".colorOption").forEach(e => e.classList.remove("selected"));
                this.classList.add("selected");
                document.getElementById("inputColor").value           = this.dataset.color;
                document.getElementById("colorToggleBtn").textContent = "🎨 " + this.textContent;
                document.getElementById("colorPicker").style.display  = "none";
            });
        });


        // ==============================
        // ナビゲーション
        // ==============================

        function prevMonth() {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            renderCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            renderCalendar();
        }

        function goToday() {
            const now    = new Date();
            currentYear  = now.getFullYear();
            currentMonth = now.getMonth();
            renderCalendar();
        }


        // ==============================
        // UI表示切替
        // ==============================

        function updateUI() {
            document.getElementById("monthNav").style.display = "flex";
        }
        
    </script>

</body>
</html>