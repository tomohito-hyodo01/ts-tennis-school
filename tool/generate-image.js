import https from 'https';
import fs from 'fs';
import path from 'path';

// APIキーと設定
const API_KEY = 'AIzaSyDX19h9SHBkTgF9tsQuOGRIkfu9iH5Tfnc';
const MODEL = 'gemini-3-pro-image-preview';
const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/${MODEL}:generateContent`;

/**
 * Gemini APIに画像生成リクエストを送信
 * @param {string} prompt - 画像生成のプロンプト
 * @returns {Promise<object>} APIレスポンス
 */
async function generateImage(prompt) {
  const requestData = {
    contents: [
      {
        parts: [
          {
            text: prompt
          }
        ]
      }
    ],
    generationConfig: {
      temperature: 1.0,
      topP: 0.95,
      topK: 40,
      maxOutputTokens: 8192
    }
  };

  return new Promise((resolve, reject) => {
    const requestBody = JSON.stringify(requestData);
    
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-goog-api-key': API_KEY,
        'Content-Length': Buffer.byteLength(requestBody)
      }
    };

    const req = https.request(API_URL, options, (res) => {
      let data = '';

      res.on('data', (chunk) => {
        data += chunk;
      });

      res.on('end', () => {
        try {
          const response = JSON.parse(data);
          resolve(response);
        } catch (error) {
          reject(new Error(`JSONパースエラー: ${error.message}`));
        }
      });
    });

    req.on('error', (error) => {
      reject(error);
    });

    req.write(requestBody);
    req.end();
  });
}

/**
 * Base64画像データをファイルに保存
 * @param {string} base64Data - Base64エンコードされた画像データ
 * @param {string} filename - 保存するファイル名
 */
function saveImage(base64Data, filename) {
  const outputDir = './output';
  
  // outputディレクトリが存在しない場合は作成
  if (!fs.existsSync(outputDir)) {
    fs.mkdirSync(outputDir);
  }

  const filepath = path.join(outputDir, filename);
  const buffer = Buffer.from(base64Data, 'base64');
  
  fs.writeFileSync(filepath, buffer);
  console.log(`✓ 画像を保存しました: ${filepath}`);
}

/**
 * レスポンスから画像データを抽出して保存
 * @param {object} response - APIレスポンス
 * @param {string} baseFilename - 基本ファイル名
 */
function extractAndSaveImages(response, baseFilename) {
  if (!response.candidates || response.candidates.length === 0) {
    console.error('画像が生成されませんでした');
    console.log('レスポンス:', JSON.stringify(response, null, 2));
    return;
  }

  let imageCount = 0;
  
  response.candidates.forEach((candidate, candidateIndex) => {
    if (candidate.content && candidate.content.parts) {
      candidate.content.parts.forEach((part, partIndex) => {
        if (part.inlineData && part.inlineData.data) {
          const mimeType = part.inlineData.mimeType || 'image/png';
          const extension = mimeType.split('/')[1] || 'png';
          const filename = `${baseFilename}_${imageCount}.${extension}`;
          
          saveImage(part.inlineData.data, filename);
          imageCount++;
        }
      });
    }
  });

  if (imageCount === 0) {
    console.log('レスポンスに画像データが含まれていません');
    console.log('完全なレスポンス:', JSON.stringify(response, null, 2));
  }
}

// メイン実行
async function main() {
  // コマンドライン引数からプロンプトを取得（指定されていない場合はデフォルト）
  const prompt = process.argv[2] || 'A beautiful sunset over mountains, photorealistic, 4k';
  
  console.log('=== Gemini 3 Pro Image Preview - 画像生成 ===');
  console.log(`プロンプト: ${prompt}`);
  console.log('画像を生成中...\n');

  try {
    const response = await generateImage(prompt);
    
    // タイムスタンプでファイル名を生成
    const timestamp = new Date().toISOString().replace(/[:.]/g, '-').slice(0, -5);
    const baseFilename = `generated_${timestamp}`;
    
    extractAndSaveImages(response, baseFilename);
    
    // レスポンス全体もJSONとして保存
    const responseFilePath = `./output/response_${timestamp}.json`;
    fs.writeFileSync(responseFilePath, JSON.stringify(response, null, 2));
    console.log(`\n✓ APIレスポンスを保存しました: ${responseFilePath}`);
    
  } catch (error) {
    console.error('エラーが発生しました:', error.message);
    process.exit(1);
  }
}

main();
