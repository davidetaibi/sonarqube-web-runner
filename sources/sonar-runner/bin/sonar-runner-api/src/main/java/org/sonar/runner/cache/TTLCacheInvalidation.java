/*
 * SonarQube Runner - API
 * Copyright (C) 2011-2016 SonarSource SA
 * mailto:contact AT sonarsource DOT com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
package org.sonar.runner.cache;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.attribute.BasicFileAttributes;

class TTLCacheInvalidation implements PersistentCacheInvalidation {
  private final long durationToExpireMs;

  TTLCacheInvalidation(long durationToExpireMs) {
    this.durationToExpireMs = durationToExpireMs;
  }
  
  @Override
  public boolean test(Path cacheEntryPath) throws IOException {
    BasicFileAttributes attr = Files.readAttributes(cacheEntryPath, BasicFileAttributes.class);
    long modTime = attr.lastModifiedTime().toMillis();

    long age = System.currentTimeMillis() - modTime;

    if (age > durationToExpireMs) {
      return true;
    }

    return false;
  }

}
