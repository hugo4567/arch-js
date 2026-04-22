<?php
// On charge les dépendances (comme dans AdminPannel.php)
require_once __DIR__ . "/Backend/DB/db_connect.php";
require_once __DIR__ . "/Backend/CRUD/levels.crud.php";

session_start();

if(!isset($_SESSION["crea"])) {
    header("Location: login.php");
    exit;
}

// Interception de la requête de sauvegarde 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'save_level') {
    header('Content-Type: application/json');
    
    // Récupération du JSON envoyé par le JavaScript
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if ($data) {
        $levelName = $data['Name'];
        
        // Création du dossier s'il n'existe pas
        $dir = __DIR__ . '/levels';
        if (!is_dir($dir)) {
            //mkdir($dir, 0777, true);
        }
        
        // Sécurisation du nom de fichier (retire les espaces/caractères spéciaux) + Timestamp pour éviter d'écraser
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $levelName);
        $filename = $safeName . '_' . time() . '.json';
        $filepath = $dir . '/' . $filename;
        
        // --- 1. VÉRIFICATION ET CRÉATION DU FICHIER ---
        if (file_put_contents($filepath, $json_data)) {
            
            // --- 2. INSERTION DANS LA DB SEULEMENT SI LE FICHIER EST CRÉÉ ---
            $type = 1; // Valeur arbitraire, à adapter selon ta logique
            $id_crea = is_numeric($_SESSION["crea"]) ? $_SESSION["crea"] : 1; // la session contient le time
            $levelPathForDB = 'Levels/' . $filename; // Le chemin stocké en DB
            $nb_play = 0;
            $note_pos = 0;
            $note_neg = 0;

            try {
                // Appel de ta fonction existante
                create_level($conn, $levelName, $type, $id_crea, $levelPathForDB, $nb_play, $note_pos, $note_neg);
                echo json_encode(['success' => true, 'message' => 'Niveau sauvegardé sur le serveur et ajouté à la BDD !']);
            } catch (Exception $e) {
                // Si la base de données échoue, on nettoie le fichier orphelin
                unlink($filepath);
                echo json_encode(['success' => false, 'message' => 'Erreur BDD. Le fichier a été annulé.']);
            }

        } else {
            echo json_encode(['success' => false, 'message' => 'Erreur de droits : le serveur n\'a pas pu créer le fichier.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Données JSON corrompues.']);
    }
    exit; // On arrête le script pour ne pas charger le HTML de l'éditeur derrière l'appel AJAX
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>FAAAHHHh Level Editor</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1e1e1e;
            color: #fff;
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Barre latérale gauche (Outils) */

        #toolbar {
            width: 380px; /* On passe de 280px à 380px pour respirer */
            min-width: 350px; /* Empêche la barre de devenir trop fine */
            flex-shrink: 0; /* Empêche la zone de dessin d'écraser la barre */
            background: #252526;
            padding: 15px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            border-right: 1px solid #333;
            overflow-y: auto;
        }

        h2 {
            margin: 0 0 10px 0;
            font-size: 16px;
            border-bottom: 1px solid #444;
            padding-bottom: 5px;
            color: #0098ff;
        }

        .tool-btn {
            background: #333;
            color: white;
            border: 1px solid #555;
            padding: 8px;
            cursor: pointer;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 4px;
            transition: background 0.2s;
            font-size: 13px;
        }

            .tool-btn:hover {
                background: #444;
            }

            .tool-btn.active {
                background: #007acc;
                border-color: #0098ff;
            }

        .color-box {
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            display: inline-block;
            flex-shrink: 0;
        }

        /* Configuration du niveau */
        .settings-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
            margin-bottom: 10px;
            font-size: 13px;
            background: #2d2d30;
            padding: 8px;
            border-radius: 4px;
        }

            .settings-group label {
                color: #ccc;
            }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
        }

        input[type="text"], input[type="number"], select {
            background: #3c3c3c;
            border: 1px solid #555;
            color: white;
            padding: 5px;
            border-radius: 3px;
            font-size: 13px;
        }

        .export-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
            margin-top: auto;
        }

            .export-btn:hover {
                background: #218838;
            }

        /* Zone de dessin (Canvas) */
        #canvas-container {
            flex-grow: 1;
            background: #111;
            position: relative;
            overflow: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            background: #1e1e24;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
            cursor: crosshair;
        }

        #brush-properties {
            background: #1e1e1e;
            padding: 10px;
            border: 1px solid #444;
            border-radius: 4px;
            display: none;
        }
    </style>
</head>
<body>

    <div id="toolbar">
        <h2>Paramètres du Niveau</h2>
        <div class="settings-group" style="background:transparent; padding:0;">
            <label>Nom du niveau:</label>
            <input type="text" id="levelName" value="Nouveau Niveau">
            <label>Gravité:</label>
            <input type="number" id="levelGravity" value="20.0" step="0.1">
        </div>

        <h2>Outils & Presets</h2>
        <div id="tools-container" style="display: flex; flex-direction: column; gap: 5px;">
        </div>

        <div id="brush-properties">
            <h2 style="color: #ff9900; margin-top:0;">Propriétés de l'Objet</h2>

            <div id="uid-props" class="settings-group" style="display:none; border-left: 3px solid #0098ff;">
                <label title="Identifiant unique pour recevoir des messages">UID (Optionnel) :</label>
                <input type="text" id="propUid" placeholder="Ex: boss_music_01">
            </div>

            <div id="animator-props" class="settings-group" style="display:none; border-left: 3px solid #ffaa00;">
                <label style="color: #ffaa00; font-weight: bold;">🎞️ Animations (COG_Animator)</label>
                <div id="anim-list" style="display:flex; flex-direction:column; gap:5px;"></div>
                <button onclick="addAnimUI()" style="background:#444; color:#fff; border:1px dashed #666; padding:6px; cursor:pointer; margin-top:5px; border-radius:3px;">+ Nouvelle Animation</button>
            </div>

            <div id="standard-props" class="settings-group">
                <label>Friction (0 = Glisse, 1 = Accroche):</label>
                <input type="number" id="propFriction" step="0.1">

                <label>Rebond / Restitution (0 = Lourd, 1 = Balle):</label>
                <input type="number" id="propRestitution" step="0.1">

                <label>Matériau (Rendu Visuel):</label>
                <select id="propMatType">
                    <option value="Stretch">Stretch (Répétition)</option>
                    <option value="Simple">Simple (Étirement/Unique)</option>
                </select>

                <div style="background: #1a1a1a; padding: 8px; border-left: 3px solid #00cc88; border-radius: 3px; margin: 8px 0;">
                    <label style="color: #00ff77; font-weight: bold; display: block; margin-bottom: 6px;">🎨 Sélection de Tile</label>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 6px; margin-bottom: 6px;">
                        <div>
                            <label style="font-size: 11px; color: #aaa;">Colonne X:</label>
                            <input type="number" id="propAtlasX" step="1" min="0">
                        </div>
                        <div>
                            <label style="font-size: 11px; color: #aaa;">Ligne Y:</label>
                            <input type="number" id="propAtlasY" step="1" min="0">
                        </div>
                    </div>

                    <div style="background: #222; border: 1px solid #555; padding: 6px; border-radius: 3px; text-align: center; font-family: monospace; font-size: 12px;">
                        <div style="color: #0098ff; margin-bottom: 4px;">
                            <strong>Offset calculé:</strong>
                        </div>
                        <div id="tileOffsetPreview" style="color: #fff; font-weight: bold;">
                            [0.000, 0.000]
                        </div>
                    </div>
                </div>

                <div style="margin-top: 15px; border-top: 1px dashed #555; padding-top: 10px;">
                    <label style="color: #0098ff; font-weight: bold;">📋 Sélecteur de Tile</label>

                    <div style="display: flex; gap: 8px; margin-bottom: 8px; align-items: center;">
                        <div style="flex: 1;">
                            <label style="display: block; margin-bottom: 3px; font-size: 12px;">Atlas :</label>
                            <input type="text" id="atlasPath" value="atlas.png" style="width: 100%;">
                        </div>
                        <button onclick="reloadAtlas()" style="background: #007acc; border: 1px solid #0098ff; color: white; padding: 8px 12px; cursor: pointer; border-radius: 3px; font-size: 12px; margin-top: 18px;">🔄 Charger</button>
                    </div>

                    <div style="display: flex; gap: 5px; align-items: center; margin-bottom: 8px;">
                        <div style="flex: 1;">
                            <label style="margin: 0; font-size: 12px;">Taille tuile (px):</label>
                            <input type="number" id="atlasTileSize" value="64" step="1" min="1" style="width: 100%;">
                        </div>
                        <div style="flex: 1;">
                            <label style="margin: 0; font-size: 12px;">Tuile sélectionnée:</label>
                            <div style="background: #1e1e1e; border: 1px solid #555; padding: 4px 8px; border-radius: 3px; font-family: monospace; font-size: 12px; color: #0098ff;">
                                <span id="tileIndicator">X:0 Y:0</span>
                            </div>
                        </div>
                    </div>

                    <div style="background: #222; border: 2px solid #444; overflow: hidden; border-radius: 4px; position: relative; aspect-ratio: auto;">
                        <canvas id="atlasCanvas" style="width: 100%; height: auto; cursor: crosshair; display: block; background: #111;"></canvas>
                    </div>
                    <img id="atlasImgSource" src="atlas.png" style="display: none;">

                    <div style="margin-top: 5px; font-size: 11px; color: #888;">
                        💡 Cliquez sur une tuile dans l'atlas pour la sélectionner
                    </div>
                </div>
            </div>

            <div id="zone-props" class="settings-group" style="display:none;">
                <label>Largeur de la zone (px):</label>
                <input type="number" id="propZoneW" step="50" min="50">

                <label>Hauteur de la zone (px):</label>
                <input type="number" id="propZoneH" step="50" min="50">
            </div>

            <div id="trigger-props" class="settings-group" style="display:none; border-left: 3px solid #ff3333;">
                <label>Target UID (Cible à contacter):</label>
                <input type="text" id="propTargetUid" placeholder="Ex: boss_music_01">
                <label>Message à envoyer (Ex: play, stop):</label>
                <input type="text" id="propMessage" value="play">
                <label class="checkbox-label">
                    <input type="checkbox" id="propTriggerOnce" checked> Se déclenche 1 seule fois
                </label>
            </div>

            <div id="audio-props" class="settings-group" style="display:none; border-left: 3px solid #ff00ff;">
                <label>Fichier Audio (OGG/MP3/WAV):</label>
                <input type="text" id="propOggPath" value="assets/tracks/music.ogg">
                <label>Volume:</label>
                <input type="number" id="propVolume" step="0.1" min="0" max="1" value="0.5">
                <label class="checkbox-label">
                    <input type="checkbox" id="propPlayOnAwake" checked> Play on Awake
                </label>
                <label class="checkbox-label">
                    <input type="checkbox" id="propLoop" checked> Boucle (Loop)
                </label>
            </div>

        </div>

        <h2 style="margin-top: 15px;">Actions</h2>
        <button class="tool-btn" data-tool="Eraser"><span class="color-box" style="background:#ff3333;"></span> Gomme</button>
        <button class="tool-btn" onclick="clearLevel()">🗑️ Tout effacer</button>

        <button class="export-btn" onclick="exportJSON()">💾 Exporter JSON</button>
    </div>

    <div id="canvas-container">
        <canvas id="levelCanvas" width="3200" height="1200"></canvas>
    </div>

    <script>
        const canvas = document.getElementById('levelCanvas');
        const ctx = canvas.getContext('2d');
        const TILE_SIZE = 50;

        // --- Fonctions de l'interface d'animation ---
        window.addAnimUI = function (name = "Idle", duration = 0.1, loop = true, frames = "") {
            const container = document.getElementById('anim-list');
            const div = document.createElement('div');
            div.style = "background:#111; border:1px solid #444; padding:6px; border-radius:3px; position:relative;";
            div.innerHTML = `
                    <div style="display:flex; gap:5px; margin-bottom:5px;">
                        <input type="text" class="anim-name" value="${name}" placeholder="Nom" style="width:70px; font-size:11px;">
                        <input type="number" class="anim-dur" value="${duration}" step="0.05" title="Vitesse (sec)" style="width:45px; font-size:11px;">
                        <label style="font-size:11px; display:flex; align-items:center;"><input type="checkbox" class="anim-loop" ${loop ? 'checked' : ''}> Loop</label>
                        <button onclick="this.parentElement.parentElement.remove()" style="background:#a00; color:#fff; border:none; padding:2px 5px; cursor:pointer; margin-left:auto; border-radius:2px;">X</button>
                    </div>
                    <div style="display:flex; gap:2px;">
                        <input type="text" class="anim-frames" value="${frames}" placeholder="ex: 0,0 1,0" title="Frames (X,Y)" style="flex:1; font-size:11px;">
                        <button onclick="addCurrentFrameToInput(this)" style="background:#00cc88; color:#000; border:none; cursor:pointer; font-size:11px; padding:2px 6px; font-weight:bold; border-radius:2px;" title="Ajouter la tuile sélectionnée">➕ Tile</button>
                    </div>
                `;
            container.appendChild(div);
        };

        window.addCurrentFrameToInput = function (btn) {
            const input = btn.previousElementSibling;
            const x = document.getElementById('propAtlasX').value;
            const y = document.getElementById('propAtlasY').value;
            const newFrame = `${x},${y}`;
            input.value = input.value.trim() === "" ? newFrame : input.value + " " + newFrame;
        };
        // ----------------------------------------------------

        // ==========================================
        // DÉFINITION DES OUTILS ET PRESETS
        // ==========================================
        const tools = {
            'Cursor': { label: '👆 Déplacer', color: 'transparent', hideProps: true },
            'Player': { label: 'Joueur', color: '#fff', draw: 'player', isUnique: true, hideProps: true },
            'Coin': { label: 'Pièce', color: '#ffcc00', draw: 'circle', hideProps: true, props: { atlasX: 0, atlasY: 2 } },

            // NOUVEL OUTIL ANIMÉ
            'AnimatedProp': { label: '🌟 Objet Animé', color: '#ffaa00', draw: 'rect', hasUid: true, hasAnimator: true, props: { friction: 0.1, restitution: 0.0, matType: 'Simple', atlasX: 0, atlasY: 0, shape: 'Rectangle' } },

            // NOUVEAUX OUTILS : Événements
            'AudioSource': { label: 'Source Audio', color: '#ff00ff', draw: 'audio', hasUid: true, isAudio: true, props: { uid: '', oggPath: 'assets/tracks/music.ogg', playOnAwake: true, volume: 0.5, loop: true } },
            'Trigger': { label: 'Trigger Event', color: 'rgba(255, 50, 50, 0.3)', draw: 'zone', isZone: true, isTrigger: true, hasUid: true, props: { zoneW: 100, zoneH: 100, uid: '', targetUid: '', message: 'play', triggerOnce: true } },

            'CamZone': { label: 'Zone Caméra', color: 'rgba(255, 255, 0, 0.3)', draw: 'zone', isZone: true, props: { zoneW: 800, zoneH: 600 } },

            'Wall': { label: 'Mur Standard', color: '#888', draw: 'rect', props: { friction: 0.1, restitution: 0.0, matType: 'Stretch', atlasX: 1, atlasY: 0, shape: 'Rectangle' } },
            'Ice': { label: 'Mur Glace', color: '#99e6ff', draw: 'rect', props: { friction: 0.0, restitution: 0.0, matType: 'Stretch', atlasX: 0, atlasY: 1, shape: 'Rectangle' } },
            'Bouncy': { label: 'Trampoline', color: '#ff66b2', draw: 'rect', props: { friction: 0.1, restitution: 1.2, matType: 'Stretch', atlasX: 5, atlasY: 0, shape: 'Rectangle' } },

            'SlopeRight': { label: 'Pente Droite (/|)', color: '#666', draw: 'slopeRight', props: { friction: 0.1, restitution: 0.0, matType: 'Simple', atlasX: 2, atlasY: 0, shape: 'SlopeRight' } },
            'SlopeLeft': { label: 'Pente Gauche (|\\)', color: '#666', draw: 'slopeLeft', props: { friction: 0.1, restitution: 0.0, matType: 'Simple', atlasX: 3, atlasY: 0, shape: 'SlopeLeft' } },

            'IceSlopeRight': { label: 'Pente Glace Droite (/|)', color: '#66ccff', draw: 'slopeRight', props: { friction: 0.0, restitution: 0.0, matType: 'Simple', atlasX: 2, atlasY: 1, shape: 'SlopeRight' } },
            'IceSlopeLeft': { label: 'Pente Glace Gauche (|\\)', color: '#66ccff', draw: 'slopeLeft', props: { friction: 0.0, restitution: 0.0, matType: 'Simple', atlasX: 3, atlasY: 1, shape: 'SlopeLeft' } },
        };

        let currentTool = 'Wall';
        let isDrawing = false;
        let objects = [];

        let draggedObject = null;
        let dragOffsetX = 0;
        let dragOffsetY = 0;

        // Initialisation de l'UI
        const toolsContainer = document.getElementById('tools-container');
        for (let key in tools) {
            let t = tools[key];
            let btn = document.createElement('button');
            btn.className = `tool-btn ${key === currentTool ? 'active' : ''}`;
            btn.dataset.tool = key;
            btn.innerHTML = `<span class="color-box" style="background:${t.color};"></span> ${t.label}`;
            toolsContainer.appendChild(btn);
        }

        // Gérer le clic sur les boutons d'outils
        document.querySelectorAll('.tool-btn[data-tool]').forEach(btn => {
            btn.addEventListener('click', (e) => {
                document.querySelectorAll('.tool-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentTool = btn.dataset.tool;
                updateBrushPropertiesUI();
            });
        });

        // Met à jour le panneau de propriétés en fonction de l'outil sélectionné
        function updateBrushPropertiesUI() {
            const propsPanel = document.getElementById('brush-properties');

            // Masquer tout par défaut
            ['uid-props', 'animator-props', 'standard-props', 'zone-props', 'trigger-props', 'audio-props'].forEach(id => {
                document.getElementById(id).style.display = 'none';
            });

            if (currentTool === 'Eraser' || tools[currentTool].hideProps) {
                propsPanel.style.display = 'none';
                return;
            }

            propsPanel.style.display = 'block';
            const defProps = tools[currentTool].props;

            // Afficher le champ UID si supporté
            if (tools[currentTool].hasUid || tools[currentTool].isAudio || tools[currentTool].isTrigger) {
                document.getElementById('uid-props').style.display = 'flex';
                document.getElementById('propUid').value = defProps.uid || '';
            }

            // Gestion de l'animateur
            if (tools[currentTool].hasAnimator) {
                document.getElementById('animator-props').style.display = 'flex';
                if (document.getElementById('anim-list').children.length === 0) {
                    addAnimUI("Idle", 0.1, true, "");
                }
            }

            // Gestion de l'affichage selon le type d'outil
            if (tools[currentTool].isAudio) {
                document.getElementById('audio-props').style.display = 'flex';
                document.getElementById('propOggPath').value = defProps.oggPath;
                document.getElementById('propVolume').value = defProps.volume;
                document.getElementById('propPlayOnAwake').checked = defProps.playOnAwake;
                document.getElementById('propLoop').checked = defProps.loop;
            }
            else if (tools[currentTool].isTrigger) {
                document.getElementById('zone-props').style.display = 'flex';
                document.getElementById('trigger-props').style.display = 'flex';
                document.getElementById('propZoneW').value = defProps.zoneW;
                document.getElementById('propZoneH').value = defProps.zoneH;
                document.getElementById('propTargetUid').value = defProps.targetUid;
                document.getElementById('propMessage').value = defProps.message;
                document.getElementById('propTriggerOnce').checked = defProps.triggerOnce;
            }
            else if (tools[currentTool].isZone) {
                document.getElementById('zone-props').style.display = 'flex';
                document.getElementById('propZoneW').value = defProps.zoneW;
                document.getElementById('propZoneH').value = defProps.zoneH;
            }
            else {
                document.getElementById('standard-props').style.display = 'flex';
                document.getElementById('propFriction').value = defProps.friction;
                document.getElementById('propRestitution').value = defProps.restitution;
                document.getElementById('propMatType').value = defProps.matType;
                document.getElementById('propAtlasX').value = defProps.atlasX;
                document.getElementById('propAtlasY').value = defProps.atlasY;
            }

            // Rafraîchir le sélecteur d'atlas si la fonction existe
            if (typeof drawAtlasPicker === 'function') drawAtlasPicker();
        }

        // Récupère les propriétés actuelles de l'UI pour le bloc à peindre
        function getCurrentBrushProps() {
            if (currentTool === 'Eraser' || tools[currentTool].hideProps) return {};

            let props = {};
            if (document.getElementById('uid-props').style.display !== 'none') {
                props.uid = document.getElementById('propUid').value;
            }

            if (tools[currentTool].hasAnimator) {
                props.animations = [];
                document.querySelectorAll('#anim-list > div').forEach(div => {
                    props.animations.push({
                        name: div.querySelector('.anim-name').value,
                        duration: parseFloat(div.querySelector('.anim-dur').value) || 0.1,
                        loop: div.querySelector('.anim-loop').checked,
                        frames: div.querySelector('.anim-frames').value
                    });
                });
            }

            if (tools[currentTool].isAudio) {
                props.oggPath = document.getElementById('propOggPath').value;
                props.volume = parseFloat(document.getElementById('propVolume').value) || 0.5;
                props.playOnAwake = document.getElementById('propPlayOnAwake').checked;
                props.loop = document.getElementById('propLoop').checked;
            }
            else if (tools[currentTool].isTrigger) {
                props.zoneW = parseInt(document.getElementById('propZoneW').value) || 100;
                props.zoneH = parseInt(document.getElementById('propZoneH').value) || 100;
                props.targetUid = document.getElementById('propTargetUid').value;
                props.message = document.getElementById('propMessage').value;
                props.triggerOnce = document.getElementById('propTriggerOnce').checked;
            }
            else if (tools[currentTool].isZone) {
                props.zoneW = parseInt(document.getElementById('propZoneW').value) || 800;
                props.zoneH = parseInt(document.getElementById('propZoneH').value) || 600;
            }
            else {
                props.shape = tools[currentTool].props.shape;
                props.friction = parseFloat(document.getElementById('propFriction').value) || 0;
                props.restitution = parseFloat(document.getElementById('propRestitution').value) || 0;
                props.matType = document.getElementById('propMatType').value;
                props.atlasX = parseInt(document.getElementById('propAtlasX').value) || 0;
                props.atlasY = parseInt(document.getElementById('propAtlasY').value) || 0;
            }

            return props;
        }

        // ==========================================
        // DESSIN DU CANVAS
        // ==========================================
        function draw() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Grille
            ctx.strokeStyle = '#333'; ctx.lineWidth = 1;
            for (let x = 0; x <= canvas.width; x += TILE_SIZE) { ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, canvas.height); ctx.stroke(); }
            for (let y = 0; y <= canvas.height; y += TILE_SIZE) { ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(canvas.width, y); ctx.stroke(); }

            // Récupérer les infos de l'atlas
            const atlasImg = document.getElementById('atlasImgSource');
            const aTileSize = parseInt(document.getElementById('atlasTileSize').value) || 64;
            const isAtlasLoaded = atlasImg && atlasImg.complete && atlasImg.naturalWidth > 0;

            // Objets
            objects.forEach(obj => {
                let x = obj.x * TILE_SIZE;
                let y = obj.y * TILE_SIZE;
                let def = tools[obj.type];
                if (!def) return;

                ctx.fillStyle = def.color;

                // Est-ce qu'on doit (et peut) utiliser la texture ?
                let useTexture = isAtlasLoaded && obj.props && obj.props.atlasX !== undefined;

                // --- DESSIN DES BLOCS TEXTURÉS ---
                if (['rect', 'slopeRight', 'slopeLeft', 'circle'].includes(def.draw)) {
                    ctx.save();
                    try {
                        ctx.beginPath();

                        // 1. Définir la forme (masque)
                        if (def.draw === 'rect') {
                            ctx.rect(x, y, TILE_SIZE, TILE_SIZE);
                        }
                        else if (def.draw === 'circle') {
                            if (useTexture) ctx.rect(x, y, TILE_SIZE, TILE_SIZE);
                            else ctx.arc(x + 25, y + 25, 15, 0, Math.PI * 2);
                        }
                        else if (def.draw === 'slopeRight') {
                            ctx.moveTo(x, y + TILE_SIZE);
                            ctx.lineTo(x + TILE_SIZE, y + TILE_SIZE);
                            ctx.lineTo(x + TILE_SIZE, y);
                            ctx.closePath();
                        }
                        else if (def.draw === 'slopeLeft') {
                            ctx.moveTo(x, y);
                            ctx.lineTo(x, y + TILE_SIZE);
                            ctx.lineTo(x + TILE_SIZE, y + TILE_SIZE);
                            ctx.closePath();
                        }

                        // 2. Peindre (Texture ou Couleur)
                        if (useTexture) {
                            ctx.clip(); // Découpe selon la forme
                            let sX = obj.props.atlasX * aTileSize;
                            let sY = obj.props.atlasY * aTileSize;
                            ctx.drawImage(atlasImg, sX, sY, aTileSize, aTileSize, x, y, TILE_SIZE, TILE_SIZE);
                        } else {
                            ctx.fill(); // Couleur de secours
                        }
                    } catch (err) {
                        // Si drawImage échoue (image corrompue ou hors limite), on colorie
                        ctx.fill();
                    } finally {
                        // CRITIQUE : Toujours relâcher le masque, même s'il y a eu une erreur !
                        ctx.restore();
                    }
                }

                // --- DESSIN DES AUTRES ÉLÉMENTS ---
                else if (def.draw === 'player') {
                    ctx.fillRect(x + 10, y + 10, 30, 30);
                    ctx.fillStyle = '#000';
                    ctx.fillText("P1", x + 15, y + 30);
                }
                else if (def.draw === 'audio') {
                    ctx.fillRect(x + 10, y + 10, 30, 30);
                    ctx.fillStyle = '#fff';
                    ctx.font = "16px Arial";
                    ctx.fillText("🎵", x + 15, y + 32);
                    if (obj.props && obj.props.uid) {
                        ctx.fillStyle = '#ff00ff';
                        ctx.font = "10px Arial";
                        ctx.fillText(obj.props.uid, x, y + 50);
                    }
                }
                else if (def.draw === 'zone') {
                    let w = obj.props.zoneW || 100;
                    let h = obj.props.zoneH || 100;
                    ctx.fillRect(x, y, w, h);

                    ctx.strokeStyle = obj.type === 'Trigger' ? '#ff3333' : '#ffff00';
                    ctx.lineWidth = 2;
                    ctx.strokeRect(x, y, w, h);

                    ctx.fillStyle = '#fff';
                    ctx.font = "14px Arial";
                    let text = obj.type === 'Trigger' ? "⚡ TRIGGER" : "📷 CAM ZONE";
                    ctx.fillText(`${text} (${w}x${h})`, x + 5, y + 20);
                }
            });
        }

        function placeObject(gridX, gridY) {
            if (currentTool === 'Cursor') return; // Le curseur ne place rien

            if (currentTool === 'Eraser') {
                // La gomme supprime TOUT ce qui commence exactement à cette case (Zone et Objets)
                objects = objects.filter(o => o.x !== gridX || o.y !== gridY);
                draw();
                return;
            }

            let toolDef = tools[currentTool];

            // LOGIQUE DE STACKING (Couches)
            // On vérifie si l'outil actuel est une Zone, et si l'objet à cet emplacement est une Zone
            objects = objects.filter(o => {
                let isObjZone = tools[o.type].isZone === true;
                let isToolZone = toolDef.isZone === true;

                // On écrase l'objet SEULEMENT si c'est la même case ET qu'ils sont sur la même couche
                if (o.x === gridX && o.y === gridY && isObjZone === isToolZone) {
                    return false; // Supprimer l'ancien
                }
                return true; // Conserver l'objet (stacking)
            });

            if (toolDef.isUnique) objects = objects.filter(o => o.type !== currentTool);

            objects.push({
                type: currentTool,
                x: gridX,
                y: gridY,
                props: getCurrentBrushProps()
            });

            draw();
        }

        canvas.addEventListener('mousedown', (e) => {
            let rect = canvas.getBoundingClientRect();
            let mouseX = e.clientX - rect.left;
            let mouseY = e.clientY - rect.top;
            let gridX = Math.floor(mouseX / TILE_SIZE);
            let gridY = Math.floor(mouseY / TILE_SIZE);

            if (currentTool === 'Cursor') {
                // Recherche de l'objet cliqué (on parcourt à l'envers pour attraper celui du dessus)
                for (let i = objects.length - 1; i >= 0; i--) {
                    let o = objects[i];
                    let t = tools[o.type];

                    // Calcul de la "hitbox" réelle de l'objet
                    let w = t.isZone ? (o.props.zoneW || 100) : TILE_SIZE;
                    let h = t.isZone ? (o.props.zoneH || 100) : TILE_SIZE;
                    let ox = o.x * TILE_SIZE;
                    let oy = o.y * TILE_SIZE;

                    // Si le clic est dans la hitbox
                    if (mouseX >= ox && mouseX < ox + w && mouseY >= oy && mouseY < oy + h) {
                        draggedObject = o;
                        // Mémorise le décalage entre la souris et l'origine de l'objet
                        dragOffsetX = o.x - gridX;
                        dragOffsetY = o.y - gridY;
                        break; // Objet trouvé, on arrête de chercher
                    }
                }
            } else {
                isDrawing = true;
                placeObject(gridX, gridY);
            }
        });

        canvas.addEventListener('mousemove', (e) => {
            let rect = canvas.getBoundingClientRect();
            let mouseX = e.clientX - rect.left;
            let mouseY = e.clientY - rect.top;
            let gridX = Math.floor(mouseX / TILE_SIZE);
            let gridY = Math.floor(mouseY / TILE_SIZE);

            if (currentTool === 'Cursor' && draggedObject) {
                // Déplacer l'objet avec le bon décalage
                draggedObject.x = gridX + dragOffsetX;
                draggedObject.y = gridY + dragOffsetY;
                draw();
            } else if (isDrawing) {
                placeObject(gridX, gridY);
            }
        });

        canvas.addEventListener('mouseup', () => {
            isDrawing = false;
            draggedObject = null;
        });

        canvas.addEventListener('mouseleave', () => {
            isDrawing = false;
            draggedObject = null;
        });

        function clearLevel() { if (confirm("Tout effacer ?")) { objects = []; draw(); } }

        // ==========================================
        // EXPORT JSON INTELLIGENT
        // ==========================================
        function exportJSON() {
            let scene = {
                Name: document.getElementById('levelName').value,
                Gravity: parseFloat(document.getElementById('levelGravity').value),
                GameObjects: []
            };

            // Calcul du ratio de normalisation
            const tileSize = parseInt(document.getElementById('atlasTileSize').value) || 64;
            const atlasSize = document.getElementById('atlasImgSource').naturalWidth || 512;
            const normRatio = tileSize / atlasSize;

            let sortedObjects = [...objects].sort((a, b) => {
                if (a.y === b.y) return a.x - b.x;
                return a.y - b.y;
            });

            // Fusion horizontale pour les murs
            let mergedObjects = [];
            let skipIndex = new Set();

            for (let i = 0; i < sortedObjects.length; i++) {
                if (skipIndex.has(i)) continue;

                let current = sortedObjects[i];
                let width = 1;

                if (['Wall', 'Ice', 'Bouncy'].includes(current.type)) {
                    for (let j = i + 1; j < sortedObjects.length; j++) {
                        let next = sortedObjects[j];
                        if (next.y === current.y && next.x === current.x + width && next.type === current.type && JSON.stringify(next.props) === JSON.stringify(current.props)) {
                            width++;
                            skipIndex.add(j);
                        } else {
                            break;
                        }
                    }
                }
                mergedObjects.push({ ...current, widthInTiles: width });
            }

            let objCounter = 0;
            mergedObjects.forEach(obj => {
                let realX = obj.x * TILE_SIZE;
                let realY = obj.y * TILE_SIZE;
                let realW = obj.widthInTiles * TILE_SIZE || TILE_SIZE;
                let realH = TILE_SIZE;
                objCounter++;

                let gameObject = {
                    Name: obj.type + "_" + objCounter,
                    Transform: { X: realX, Y: realY, W: realW, H: realH },
                    Components: []
                };

                // Ajout de l'UID si l'objet en a un
                if (obj.props.uid && obj.props.uid.trim() !== "") {
                    gameObject.Uid = obj.props.uid.trim();
                }

                if (obj.type === 'Player') {
                    gameObject.Name = "Player";
                    gameObject.Components.push({ "Type": "COG_PlayerController", "Speed": 8.0, "JumpImpulse": 15.0 });
                    gameObject.Components.push({ "Type": "COG_Collider", "IsSolid": true, "Friction": 0.0, "BodyType": "Dynamic", "Shape": "PlayerBox" });
                    gameObject.Components.push({ "Type": "COG_RopeClimber" });
                    gameObject.Components.push({ "Type": "COG_Sprite", "TexturePath": "atlas.png", "LayerDepth": 0.5, "AtlasOffset": [0.5, 0.0], "AtlasSize": [0.125, 0.125] });
                }
                else if (obj.type === 'Coin') {
                    gameObject.Components.push({ "Type": "COG_Collider", "IsSolid": false, "IsTrigger": true, "BodyType": "Static" });
                    gameObject.Components.push({ "Type": "COG_CoinBehavior" });
                    let pX = (tools['Coin'].props.atlasX * normRatio);
                    let pY = (tools['Coin'].props.atlasY * normRatio);
                    gameObject.Components.push({ "Type": "COG_Sprite", "TexturePath": "atlas.png", "LayerDepth": 0.4, "AtlasOffset": [pX, pY], "AtlasSize": [normRatio, normRatio] });
                }
                // --- EXPORT AUDIO ---
                else if (obj.type === 'AudioSource') {
                    gameObject.Components.push({
                        "Type": "COG_AudioSource",
                        "OggPath": obj.props.oggPath,
                        "Volume": obj.props.volume,
                        "PlayOnAwake": obj.props.playOnAwake,
                        "Loop": obj.props.loop
                    });
                }
                // --- EXPORT TRIGGER ---
                else if (obj.type === 'Trigger') {
                    gameObject.Transform.W = obj.props.zoneW;
                    gameObject.Transform.H = obj.props.zoneH;
                    gameObject.Components.push({ "Type": "COG_Collider", "IsSolid": false, "IsTrigger": true, "BodyType": "Static" });
                    gameObject.Components.push({
                        "Type": "COG_TriggerBehavior",
                        "TargetUid": obj.props.targetUid,
                        "MessageToSend": obj.props.message,
                        "TriggerOnce": obj.props.triggerOnce
                    });
                    gameObject.Components.push({ "Type": "COG_Sprite", "IsVisible": false, "LayerDepth": 0.2, "Color": [1.0, 0.0, 0.0, 1.0] });
                }
                // --- EXPORT CAM ZONE ---
                else if (obj.type === 'CamZone') {
                    gameObject.Transform.W = obj.props.zoneW;
                    gameObject.Transform.H = obj.props.zoneH;
                    gameObject.Components.push({ "Type": "COG_Collider", "IsSolid": false, "IsTrigger": true, "BodyType": "Static" });
                    gameObject.Components.push({ "Type": "COG_CameraZone" });
                    gameObject.Components.push({ "Type": "COG_Sprite", "IsVisible": false, "LayerDepth": 0.2, "Color": [1.0, 1.0, 0.0, 1.0] });
                }
                // --- EXPORT MURS ET PENTES ET OBJETS ANIMÉS ---
                else {
                    let p = obj.props;
                    gameObject.Components.push({
                        "Type": "COG_Collider",
                        "IsSolid": true,
                        "Friction": p.friction,
                        "Restitution": p.restitution,
                        "BodyType": obj.type === 'AnimatedProp' ? "Dynamic" : "Static",
                        "Shape": p.shape || "Rectangle"
                    });

                    gameObject.Components.push({
                        "Type": "COG_Sprite",
                        "TexturePath": "atlas.png",
                        "LayerDepth": 0.6,
                        "MatType": p.matType,
                        "TextureBaseSize": 50.0,
                        "AtlasOffset": [p.atlasX * normRatio, p.atlasY * normRatio],
                        "AtlasSize": [normRatio, normRatio]
                    });

                    // --- EXPORT DE L'ANIMATEUR ---
                    if (p.animations && p.animations.length > 0) {
                        let animData = {
                            "Type": "COG_Animator",
                            "Animations": p.animations.map(a => {
                                let frameCoords = a.frames.trim().split(' ').map(f => {
                                    if (!f) return null;
                                    let parts = f.split(',');
                                    let px = parseInt(parts[0]) || 0;
                                    let py = parseInt(parts[1]) || 0;
                                    return [px * normRatio, py * normRatio]; // Calcul direct des UV via normRatio
                                }).filter(f => f != null);
                                return { "Name": a.name, "FrameDuration": a.duration, "Loop": a.loop, "Frames": frameCoords };
                            })
                        };
                        gameObject.Components.push(animData);
                    }
                }

                scene.GameObjects.push(gameObject);
            });

            // ==========================================
            // NOUVEAU : ENVOI AU SERVEUR AU LIEU DU TÉLÉCHARGEMENT
            // ==========================================
            const exportBtn = document.querySelector('.export-btn');
            const originalText = exportBtn.innerHTML;
            exportBtn.innerHTML = "⏳ Sauvegarde en cours...";
            exportBtn.disabled = true;

            fetch('editor.php?action=save_level', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(scene, null, 2)
            })
            .then(async response => {
            const textResponse = await response.text(); // On récupère le texte brut d'abord
            try {
                return JSON.parse(textResponse); // On tente de le convertir en JSON
            } catch (error) {
            console.error("Erreur PHP brute : \n", textResponse); // AFFICHE L'ERREUR PHP !
            throw new Error("Le serveur a renvoyé du texte/HTML au lieu d'un JSON.");
            }
            })
            .then(data => {
                if (data.success) {
                    alert('✅ ' + data.message);
                } else {
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur réseau:', error);
                alert('Impossible de joindre le serveur.');
            })
            .finally(() => {
                exportBtn.innerHTML = "☁️ Sauvegarder sur le Serveur"; // On change l'icône !
                exportBtn.disabled = false;
            });
        }

        // ==========================================
        // TEXTURE PICKER (Sélecteur d'Atlas Visuel)
        // ==========================================
        const atlasCanvas = document.getElementById('atlasCanvas');
        const atlasCtx = atlasCanvas.getContext('2d');
        const atlasImgSource = document.getElementById('atlasImgSource');
        const atlasTileSizeInput = document.getElementById('atlasTileSize');
        const inputAtlasX = document.getElementById('propAtlasX');
        const inputAtlasY = document.getElementById('propAtlasY');
        const tileIndicatorEl = document.getElementById('tileIndicator');
        const atlasPathInput = document.getElementById('atlasPath');

        function drawAtlasPicker() {
            if (!atlasImgSource.complete || atlasImgSource.naturalWidth === 0) return;

            // Ajuster la vraie résolution du canvas à l'image
            atlasCanvas.width = atlasImgSource.naturalWidth;
            atlasCanvas.height = atlasImgSource.naturalHeight;

            atlasCtx.clearRect(0, 0, atlasCanvas.width, atlasCanvas.height);
            // On dessine l'image normalement à la position 0,0
            atlasCtx.drawImage(atlasImgSource, 0, 0);

            const tSize = parseInt(atlasTileSizeInput.value) || 64;
            const selX = parseInt(inputAtlasX.value) || 0;
            const selY = parseInt(inputAtlasY.value) || 0;

            // 1. Dessiner une grille discrète par-dessus l'image
            atlasCtx.strokeStyle = 'rgba(100, 150, 255, 0.5)';
            atlasCtx.lineWidth = 1;
            for (let x = 0; x <= atlasCanvas.width; x += tSize) {
                atlasCtx.beginPath();
                atlasCtx.moveTo(x, 0);
                atlasCtx.lineTo(x, atlasCanvas.height);
                atlasCtx.stroke();
            }
            for (let y = 0; y <= atlasCanvas.height; y += tSize) {
                atlasCtx.beginPath();
                atlasCtx.moveTo(0, y);
                atlasCtx.lineTo(atlasCanvas.width, y);
                atlasCtx.stroke();
            }

            // 2. Mettre en surbrillance la tile sélectionnée
            atlasCtx.fillStyle = 'rgba(0, 200, 100, 0.4)';
            atlasCtx.fillRect(selX * tSize, selY * tSize, tSize, tSize);
            atlasCtx.strokeStyle = '#00ff77';
            atlasCtx.lineWidth = 3;
            atlasCtx.strokeRect(selX * tSize, selY * tSize, tSize, tSize);

            // 3. Mettre à jour l'indicateur de coordonnées
            updateTileIndicator(selX, selY, tSize, atlasCanvas.width);
        }

        function updateTileIndicator(x, y, tileSize, atlasWidth) {
            const gridWidth = Math.floor(atlasWidth / tileSize);
            tileIndicatorEl.textContent = `Grille: X:${x} Y:${y}`;

            // Afficher aussi l'offset normalisé (0-1)
            const offsetX = (x * tileSize) / atlasWidth;
            const offsetY = y * tileSize / (atlasWidth * (atlasCanvas.height / atlasWidth)); // Approximation

            // Ajouter un hint visuel
            const displayText = `X:${x} Y:${y}`;
            tileIndicatorEl.textContent = displayText;
            tileIndicatorEl.title = `Offset: [${offsetX.toFixed(3)}, ${offsetY.toFixed(3)}]`;

            // Mettre à jour le preview de l'offset dans le panneau
            updateOffsetPreview();
        }

        function updateOffsetPreview() {
            const atlasX = parseInt(inputAtlasX.value) || 0;
            const atlasY = parseInt(inputAtlasY.value) || 0;
            const tileSize = parseInt(atlasTileSizeInput.value) || 64;

            // Supposer un atlas 8x8 par défaut (chaque tile = 1/8 = 0.125)
            // Formule: offset = (gridIndex * tileSize) / atlasSize
            // Mais pour la normalisation, on utilise directement la grille
            // Si tileSize=64 et atlasSize=512, alors 1 tile = 64/512 = 0.125
            const atlasSize = atlasImgSource.naturalWidth || 512;
            const normalizedTileSize = tileSize / atlasSize;

            const offsetX = atlasX * normalizedTileSize;
            const offsetY = atlasY * normalizedTileSize;

            const preview = document.getElementById('tileOffsetPreview');
            preview.textContent = `[${offsetX.toFixed(3)}, ${offsetY.toFixed(3)}]`;
        }

        function reloadAtlas() {
            const newPath = atlasPathInput.value.trim();
            if (!newPath) {
                alert('Entrez un chemin valide pour l\'atlas');
                return;
            }

            atlasImgSource.src = newPath;
            atlasImgSource.onload = drawAtlasPicker;
            atlasImgSource.onerror = function () {
                alert(`Impossible de charger l'atlas: ${newPath}`);
                atlasImgSource.src = 'atlas.png';
            };
        }

        // Quand l'image est chargée, on dessine
        atlasImgSource.onload = drawAtlasPicker;

        // Interaction au clic sur le canvas
        atlasCanvas.addEventListener('mousedown', (e) => {
            const rect = atlasCanvas.getBoundingClientRect();
            // Le canvas est redimensionné en CSS (width: 100%), il faut calculer le ratio !
            const scaleX = atlasCanvas.width / rect.width;
            const scaleY = atlasCanvas.height / rect.height;

            const x = (e.clientX - rect.left) * scaleX;
            const y = (e.clientY - rect.top) * scaleY;

            const tSize = parseInt(atlasTileSizeInput.value) || 64;

            // Éviter de cliquer sur les labels des indices
            if (x > 30 && y > 18) {
                inputAtlasX.value = Math.floor((x - 0) / tSize);
                inputAtlasY.value = Math.floor((y - 0) / tSize);
                drawAtlasPicker();
            }
        });

        // Mettre à jour si on change la taille ou si on tape à la main
        atlasTileSizeInput.addEventListener('input', drawAtlasPicker);
        inputAtlasX.addEventListener('change', () => { drawAtlasPicker(); updateOffsetPreview(); });
        inputAtlasY.addEventListener('change', () => { drawAtlasPicker(); updateOffsetPreview(); });
        inputAtlasX.addEventListener('input', updateOffsetPreview);
        inputAtlasY.addEventListener('input', updateOffsetPreview);

        // Permettre les flèches pour naviguer dans la grille
        inputAtlasX.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') { inputAtlasX.value = parseInt(inputAtlasX.value) + 1; drawAtlasPicker(); updateOffsetPreview(); }
            if (e.key === 'ArrowLeft') { inputAtlasX.value = Math.max(0, parseInt(inputAtlasX.value) - 1); drawAtlasPicker(); updateOffsetPreview(); }
        });
        inputAtlasY.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown') { inputAtlasY.value = parseInt(inputAtlasY.value) + 1; drawAtlasPicker(); updateOffsetPreview(); }
            if (e.key === 'ArrowUp') { inputAtlasY.value = Math.max(0, parseInt(inputAtlasY.value) - 1); drawAtlasPicker(); updateOffsetPreview(); }
        });

        // Init
        updateBrushPropertiesUI();
        updateOffsetPreview();
        draw();
    </script>
</body>
</html>