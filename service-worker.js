/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr 
 * Copyright (C) 2019 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK Javascript library for mobile page layout
 *
 * File version: 1.1
 * Last update: 05/31/2022
 */
'use strict';

/* global self, caches, Promise, fetch */

const CONSOLE_LOG = false; // No console log
const STATIC_CACHE_NAME = 'zdk-static-cache-v1';
const DYNAMIC_CACHE_NAME = 'zdk-dynamic-cache-v1';
const DOCUMENT_CACHE_NAME = 'zdk-document-cache';
const FILES_TO_CACHE = [
    'offline'
];
self.addEventListener('install', (evt) => {
    CONSOLE_LOG && console.log('[ServiceWorker] Install');
    evt.waitUntil(
        caches.open(STATIC_CACHE_NAME).then((cache) => {
            CONSOLE_LOG && console.log('[ServiceWorker] Pre-caching offline page');
            return cache.addAll(FILES_TO_CACHE);
        })
    );
    self.skipWaiting();
});

self.addEventListener('activate', (evt) => {
    CONSOLE_LOG && console.log('[ServiceWorker] Activate');
    evt.waitUntil(
        caches.keys().then((keyList) => {
            return Promise.all(keyList.map((key) => {
                if (key !== STATIC_CACHE_NAME && key !== DYNAMIC_CACHE_NAME
                        && key !== DOCUMENT_CACHE_NAME) {
                    CONSOLE_LOG && console.log('[ServiceWorker] Removing old cache', key);
                    return caches.delete(key);
                }
            }));
        })
    );
    self.clients.claim();
});

self.addEventListener('fetch', (evt) => {
    if (evt.request.mode === 'navigate' && !evt.request.url.includes('&action=download')) {
        CONSOLE_LOG && console.log('[ServiceWorker] Fetch (navigate)', evt.request.url);
        evt.respondWith(
            fetch(evt.request)
                .catch(() => {
                    return caches.open(STATIC_CACHE_NAME)
                        .then((cache) => {
                            return cache.match('offline');
                        });
                })
        );
    } else if (evt.request.url.includes('/resources/') || evt.request.url.includes('/public/')) {
        evt.respondWith(
            caches.open(DYNAMIC_CACHE_NAME).then((cache) => {
                return cache.match(evt.request).then(function (response) {
                    return response || fetch(evt.request).then(function(response) {
                        CONSOLE_LOG && console.log('[ServiceWorker] Fetch (dynamic cache)', evt.request.url, ' added to cache.');
                        cache.put(evt.request, response.clone());
                        return response;
                    });
                });
            }));
    } else if (evt.request.url.includes('&action=download') && evt.request.url.includes('&cache=true')) {
        evt.respondWith(
            caches.open(DOCUMENT_CACHE_NAME).then((cache) => {
                return cache.match(evt.request).then(function (response) {
                    return response || fetch(evt.request).then(function(response) {
                        CONSOLE_LOG && console.log('[ServiceWorker] Fetch (document cache)', evt.request.url, ' added to cache.');
                        cache.put(evt.request, response.clone());
                        return response;
                    });
                });
            }));
    } else {
        CONSOLE_LOG && console.log('[ServiceWorker] Fetch (Other)', evt.request.url);
    }
    
});