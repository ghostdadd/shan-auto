<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <style>
        body { background: #0f172a; color: #e2e8f0; font-family: sans-serif; padding: 40px; display: flex; justify-content: center; }
        form { background: #1e293b; padding: 30px; border-radius: 16px; width: 100%; max-width: 500px; border: 1px solid #334155; }
        h2 { color: #f8fafc; text-align: center; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 8px; font-weight: 500; color: #94a3b8; }
        input, select { width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #334155; background: #0f172a; color: white; box-sizing: border-box; }
        
        /* Стили для переключателя */
        .switch { position: relative; display: inline-block; width: 50px; height: 26px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #334155; transition: .4s; border-radius: 34px; }
        .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 4px; bottom: 4px; background-color: white; transition: .4s; border-radius: 50%; }
        input:checked + .slider { background-color: #3b82f6; }
        input:checked + .slider:before { transform: translateX(24px); }
        
        button { width: 100%; padding: 14px; background: #3b82f6; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 10px; }
    </style>
</head>
<body>
    <form action="insert.php" method="POST" enctype="multipart/form-data">
        <h2>Добавить автомобиль</h2>
        
        <div class="form-group">
            <label>Марка:</label>
            <select name="brand" onchange="document.getElementById('otherBrand').style.display = (this.value=='other') ? 'block' : 'none';">
                <option value="Zeekr">Zeekr</option><option value="BYD">BYD</option>
                <option value="Li Auto">Li Auto</option><option value="NIO">NIO</option>
                <option value="Xiaomi">Xiaomi</option><option value="Tesla">Tesla</option>
                <option value="other">Свой вариант...</option>
            </select>
            <input type="text" id="otherBrand" name="brand_custom" placeholder="Введите марку" style="display:none; margin-top:10px;">
        </div>
        <div class="form-group"><label>Модель:</label><input type="text" name="model" required></div>
        <div class="form-group"><label>Год выпуска:</label><input type="number" name="year" value="2026"></div>
        <div class="form-group"><label>Цена ($):</label><input type="number" name="price" required></div>
        <div class="form-group"><label>Двигатель:</label><input type="text" name="engine_type"></div>
        <div class="form-group"><label>Мощность (л.с.):</label><input type="number" name="power_hp"></div>
        <div class="form-group"><label>Крутящий момент:</label><input type="number" name="torque"></div>
        <div class="form-group"><label>Кузов:</label><input type="text" name="body_type"></div>
        <div class="form-group"><label>Длина (мм):</label><input type="number" name="length"></div>
        <div class="form-group"><label>Фото:</label><input type="file" name="image" accept="image/*"></div>
        
        <div class="form-group" style="display: flex; align-items: center; justify-content: space-between; background: #1e293b; padding: 12px; border-radius: 8px; border: 1px solid #334155;">
            <label style="margin: 0; color: white;">В наличии</label>
            <label class="switch"><input type="checkbox" name="is_available" value="1" checked><span class="slider"></span></label>
        </div>
        <button type="submit">Добавить в базу</button>
    </form>
</body>
</html>